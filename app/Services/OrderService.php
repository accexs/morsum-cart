<?php

namespace App\Services;

use App\Exceptions\CartEmptyException;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class OrderService
{

    protected string $cartId;

    public function __construct()
    {
        $this->cartId = config('cart.identifier');
    }

    /**
     * @throws \App\Exceptions\CartEmptyException
     * @throws \Throwable
     */
    public function createNewOrder(): Order
    {
        $order = new Order();
        Cart::restore($this->cartId);
        if (Cart::content()->isEmpty()) {
            throw new CartEmptyException();
        }
        $products = Cart::content()->mapWithKeys(function ($item) {
            return [
                $item->id => [
                    'quantity' => $item->qty,
                    'product_subtotal' => $item->subtotal,
                ],
            ];
        });

        $order->total = Cart::subtotal();

        DB::transaction(function () use($order, $products) {
            $order->saveOrFail();
            $order->products()->attach($products->toArray());
            Cart::destroy();
            Cart::store($this->cartId);
        });
        return $order;
    }

}
