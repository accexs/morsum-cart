<?php

namespace App\Http\Controllers;

use App\Exceptions\CartEmptyException;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{

    protected string $cartId;

    public function __construct()
    {
        $this->cartId = config('cart.identifier');
    }

    /**
     * @throws \Throwable
     */
    public function store(Order $order): JsonResource
    {
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

        $order->saveOrFail();
        $order->products()->attach($products->toArray());
        Cart::destroy();
        Cart::store($this->cartId);
        return OrderResource::make($order);
    }

}
