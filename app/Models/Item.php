<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'quantity',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(
            Order::class,
            'order_items',
            'item_id',
            'order_id'
        )
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
