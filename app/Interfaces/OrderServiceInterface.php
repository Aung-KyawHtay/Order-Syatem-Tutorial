<?php

namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderServiceInterface
{
    public function getAllOrders(?string $keyword = null): LengthAwarePaginator;

    public function createOrder(array $data): Order;

    public function getOrderById(int $id): Order;

    public function updateOrder(int $id, array $data): Order;

    public function deleteOrder(int $id): bool;
}
