<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],

            'items.*.item_id' => [
                'required',
                'integer',
                'exists:items,id',
                'distinct',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }
}
