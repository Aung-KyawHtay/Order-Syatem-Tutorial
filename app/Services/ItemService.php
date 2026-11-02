<?php

namespace App\Services;

use App\Models\Item;
use App\Interfaces\ItemServiceInterface;
use App\Utils\Search;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemService implements ItemServiceInterface
{
    public function getAllItems(?string $keyword = null): LengthAwarePaginator
    {
        $query = Item::query();

        Search::apply($query, $keyword, [
            'name',
            'sku',
            'description',
        ]);

        return $query->latest()->paginate(5)->withQueryString();
    }

    public function createItem(array $data): Item
    {
        return Item::create($data);
    }

    public function getItemById(int $id): Item
    {
        return Item::findOrFail($id);
    }

    public function updateItem(int $id, array $data): Item
    {
        $item = Item::findOrFail($id);

        $item->update($data);

        return $item;
    }

    public function deleteItem(int $id): bool
    {
        $item = Item::findOrFail($id);

        $hasOrders = DB::table('order_items')
            ->where('item_id', $id)
            ->exists();

        if ($hasOrders) {
            return false;
        }

        return $item->delete();
    }
}
