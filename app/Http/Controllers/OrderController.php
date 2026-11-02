<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderServiceInterface;
use App\Http\Requests\Order\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Item;

class OrderController extends Controller
{
    protected OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    // Display Order List
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $orders = $this->orderService->getAllOrders($keyword);

        return view('orders.index', compact('orders', 'keyword'));
    }

    // Show Create Order Form
    public function create()
    {
        $items = Item::where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return view('orders.create', compact('items'));
    }

    // Store New Order
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        try {

            $this->orderService->createOrder($request->validated());

            return redirect()
                ->route('orders.index')
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // Show Order Details
    public function show(int $id)
    {
        $order = $this->orderService->getOrderById($id);

        return view('orders.show', compact('order'));
    }

    // Show Edit Order Form
    public function edit(int $id)
    {
        $order = $this->orderService->getOrderById($id);

        $items = Item::orderBy('name')->get();

        return view('orders.edit', compact('order', 'items'));
    }

    // Update Order
    public function update(
        StoreOrderRequest $request,
        int $id
    ): RedirectResponse {

        try {

            $this->orderService->updateOrder(
                $id,
                $request->validated()
            );

            return redirect()
                ->route('orders.show', $id)
                ->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // Delete Order
    public function destroy(int $id): RedirectResponse
    {
        try {

            $this->orderService->deleteOrder($id);

            return redirect()
                ->route('orders.index')
                ->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
