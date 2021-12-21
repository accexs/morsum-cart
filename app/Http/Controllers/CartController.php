<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartCollection;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema (
 *     schema="Cart",
 *     title="Cart model",
 *     description="Cart model",
 *     @OA\Property(property="content", type="array",
 *     @OA\Items(
 *     @OA\Property(property="rowId", type="string"),
 *     @OA\Property(property="id", type="number"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="qty", type="number"),
 *     @OA\Property(property="price", type="number"),
 *     @OA\Property(property="subtotal", type="number"),
 *     @OA\Property(property="image", type="string")
 *     )
 *     ),
 *     @OA\Property(property="count", type="number"),
 *     @OA\Property(property="subtotal", type="number"),
 *     @OA\Property(property="total", type="number"),
 * )
 */
class CartController extends Controller
{


    protected string $cartId;

    public function __construct()
    {
        $this->cartId = config('cart.identifier');
    }


    /**
     * @OA\Get(
     *     path="/api/cart",
     *     tags={"cart"},
     *     summary="Returns cart status and items",
     *     operationId="getItems",
     *     @OA\Response(
     *         response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Cart")
     *     )
     * )
     */
    public function getItems(): JsonResource
    {
        Cart::restore($this->cartId);
        return CartCollection::make(Cart::content()->flatten());
    }

    /**
     * @OA\Patch (
     *     path="/api/cart/addItem",
     *     tags={"cart"},
     *     summary="Returns cart status and items",
     *     operationId="addItem",
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     required={"id"},
     *     @OA\Property(property="id", type="number", example="2"),
     *     @OA\Property(property="quantity", type="number", example="1")
     *     )
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Cart")
     *     )
     * )
     */
    public function addItem(Request $request): JsonResource
    {
        $product = Product::findOrFail($request->get('id'));
        $quantity = $request->get('quantity');
        Cart::restore($this->cartId);
        Cart::add($product, $quantity);
        Cart::store($this->cartId);
        return CartCollection::make(Cart::content()->flatten());
    }


    /**
     * @OA\Patch (
     *     path="/api/cart/removeItem",
     *     tags={"cart"},
     *     summary="Returns cart status and items",
     *     operationId="removeItem",
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     required={"rowId"},
     *     @OA\Property(property="id", type="string",
     *     example="370d08585360f5c568b18d1f2e4ca1df")
     *     )
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Cart")
     *     )
     * )
     */
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

    /**
     * @OA\Delete (
     *     path="/api/cart",
     *     tags={"cart"},
     *     summary="Returns cart status and items",
     *     operationId="destroy",
     *     @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Cart")
     *     )
     * )
     */
    public function destroy(Request $request): JsonResource
    {
        Cart::restore($this->cartId);
        Cart::destroy();
        Cart::store($this->cartId);
        return CartCollection::make(Cart::content()->flatten());
    }
}
