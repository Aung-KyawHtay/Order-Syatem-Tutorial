<?php

namespace App\Interfaces;

use App\Models\Item;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ItemServiceInterface
{
    public function getAllItems(?string $keyword = null): LengthAwarePaginator;

    public function createItem(array $data): Item;

    public function getItemById(int $id): Item;

    public function updateItem(int $id, array $data): Item;

    public function deleteItem(int $id): bool;
}
