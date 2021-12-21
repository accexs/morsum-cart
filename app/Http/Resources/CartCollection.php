<?php

namespace App\Http\Resources;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'content' => $this->collection,
            'count' => Cart::count(),
            'subtotal' => Cart::subtotal(),
            'total' => Cart::total(),
        ];
    }
}
