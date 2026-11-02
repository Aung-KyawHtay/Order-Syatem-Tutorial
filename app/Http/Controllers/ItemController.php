<?php

namespace App\Http\Controllers;

use App\Interfaces\ItemServiceInterface;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected ItemServiceInterface $itemService;

    public function __construct(ItemServiceInterface $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $items = $this->itemService->getAllItems($keyword);

        return view('items.index', compact('items', 'keyword'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();

        $this->itemService->createItem($data);

        return redirect()
            ->route('items.index')
            ->with('success', 'Item created successfully!');
    }

    public function edit(int $id)
    {
        $item = $this->itemService->getItemById($id);

        return view('items.edit', compact('item'));
    }

    public function update(UpdateItemRequest $request, int $id)
    {
        $data = $request->validated();

        $this->itemService->updateItem($id, $data);

        return redirect()
            ->route('items.index')
            ->with('success', 'Item updated successfully!');
    }

    public function destroy(int $id)
    {
        $deleted = $this->itemService->deleteItem($id);

        if (! $deleted) {
            return redirect()
                ->route('items.index')
                ->with('error', 'This item cannot be deleted because it is already used in an order.');
        }

        return redirect()
            ->route('items.index')
            ->with('success', 'Item deleted successfully!');
    }
}
