<?php

namespace App\Services;

use App\Models\Product;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class CartService
{

    protected string $cartId;

    public function __construct()
    {
        $this->cartId = config('cart.identifier');
    }

    public function addItemToCart(int $productId, $quantity = null): void
    {
        DB::transaction(function () use ($productId, $quantity) {
            $product = Product::findOrFail($productId);
            Cart::restore($this->cartId);
            Cart::add($product, $quantity);
            Cart::store($this->cartId);
        });
    }

    public function removeItemFromCart(string $rowId): void
    {
        DB::transaction(function () use ($rowId) {
            Cart::restore($this->cartId);
            /** @throws InvalidRowIDException */
            $product = Cart::get($rowId);
            $quantity = $product->qty - 1;
            Cart::update($rowId, $quantity);
            Cart::store($this->cartId);
        });
    }

    public function emptyCart(): void
    {
        Cart::restore($this->cartId);
        Cart::destroy();
        Cart::store($this->cartId);
    }

}
