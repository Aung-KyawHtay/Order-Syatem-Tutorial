<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Item;
use App\Interfaces\OrderServiceInterface;
use App\Utils\Search;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    public function getAllOrders(?string $keyword = null): LengthAwarePaginator
    {
        $query = Order::query()
            ->where('user_id', Auth::id());

        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {

                Search::apply($query, $keyword, [
                    'id',
                    'status',
                ]);

                $query->orWhereHas('items', function ($itemQuery) use ($keyword) {
                    $itemQuery->where('name', 'LIKE', "%{$keyword}%")
                        ->orWhere('sku', 'LIKE', "%{$keyword}%");
                });
            });
        }

        return $query->latest()->paginate(5)->withQueryString();
    }

    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {

            $items = [];
            $totalAmount = 0;

            foreach ($data['items'] as $itemData) {

                if ($itemData['quantity'] == 0) {
                    continue;
                }

                $item = Item::whereKey($itemData['item_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($item->quantity < $itemData['quantity']) {
                    throw new \Exception(
                        "Insufficient stock for item: {$item->name}"
                    );
                }

                $subtotal = $item->price * $itemData['quantity'];
                $totalAmount += $subtotal;

                $items[] = [
                    'item' => $item,
                    'quantity' => $itemData['quantity'],
                    'price' => $item->price,
                ];
            }

            if (empty($items)) {
                throw new \Exception('Please select at least one item.');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($items as $orderItem) {

                $order->items()->attach(
                    $orderItem['item']->id,
                    [
                        'quantity' => $orderItem['quantity'],
                        'price' => $orderItem['price'],
                    ]
                );

                $orderItem['item']->decrement(
                    'quantity',
                    $orderItem['quantity']
                );
            }

            return $order;
        });
    }

    public function getOrderById(int $id): Order
    {
        return Order::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
    }

    public function updateOrder(int $id, array $data): Order
    {
        return DB::transaction(function () use ($id, $data) {

            $order = Order::where('user_id', Auth::id())
                ->lockForUpdate()
                ->findOrFail($id);

            $oldItems = $order->items;

            // Lock old and new item rows in a consistent order.
            $itemIds = collect($data['items'])
                ->pluck('item_id')
                ->merge($oldItems->pluck('id'))
                ->unique()
                ->sort()
                ->values();

            $lockedItems = Item::whereIn('id', $itemIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Return previous order quantities to stock.
            foreach ($oldItems as $oldItem) {
                $lockedItems->get($oldItem->id)->increment(
                    'quantity',
                    $oldItem->pivot->quantity
                );
            }

            $newItems = [];
            $totalAmount = 0;

            foreach ($data['items'] as $itemData) {

                $quantity = (int) $itemData['quantity'];

                if ($quantity === 0) {
                    continue;
                }

                $item = $lockedItems->get($itemData['item_id']);

                if (!$item) {
                    throw new \Exception('Selected item not found.');
                }

                if ($item->quantity < $quantity) {
                    throw new \Exception(
                        "Insufficient stock for item: {$item->name}"
                    );
                }

                $price = $item->price;
                $totalAmount += $price * $quantity;

                $newItems[$item->id] = [
                    'quantity' => $quantity,
                    'price' => $price,
                ];

                $item->decrement('quantity', $quantity);
            }

            if (empty($newItems)) {
                throw new \Exception(
                    'Please select at least one item.'
                );
            }

            // Replace old order items with updated items.
            $order->items()->sync($newItems);

            $order->update([
                'total_amount' => $totalAmount,
            ]);

            return $order->load('items');
        });
    }

    public function deleteOrder(int $id): bool
    {
        return DB::transaction(function () use ($id) {

            $order = Order::where('user_id', Auth::id())
                ->lockForUpdate()
                ->findOrFail($id);

            $orderItems = $order->items;

            $itemIds = $orderItems->pluck('id')
                ->unique()
                ->sort()
                ->values();

            $lockedItems = Item::whereIn('id', $itemIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Restore stock before deleting the order.
            foreach ($orderItems as $orderItem) {

                $item = $lockedItems->get($orderItem->id);

                if ($item) {
                    $item->increment(
                        'quantity',
                        $orderItem->pivot->quantity
                    );
                }
            }

            return (bool) $order->delete();
        });
    }
}
