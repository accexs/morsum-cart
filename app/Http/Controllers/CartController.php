<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartCollection;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartController extends Controller
{

    // TODO: feature test this

    protected string $cartId;

    public function __construct()
    {
        $this->cartId = config('cart.identifier');
    }

    public function getItems(): JsonResource
    {
        Cart::restore($this->cartId);
        return CartCollection::make(Cart::content()->flatten());
    }

    public function addItem(Request $request): JsonResource
    {
        $product = Product::findOrFail($request->get('id'));
        $quantity = $request->get('quantity');
        Cart::restore($this->cartId);
        Cart::add($product, $quantity);
        Cart::store($this->cartId);
        return CartCollection::make(Cart::content()->flatten());
    }

    public function removeItem(Request $request): JsonResource
    {
        $request->validate([
            'rowId' => 'required|string',
        ]);
        $rowId = $request->get('rowId');
        Cart::restore($this->cartId);
        $product = Cart::get($rowId);
        $quantity = $product->qty - 1;
        Cart::update($rowId, $quantity);
        Cart::store($this->cartId);
        return CartCollection::make(Cart::content()->flatten());
    }

    public function destroy(Request $request): JsonResource
    {
        Cart::restore($this->cartId);
        Cart::destroy();
        Cart::store($this->cartId);
        return CartCollection::make(Cart::content()->flatten());
    }
}
