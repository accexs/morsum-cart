<?php

namespace Tests\Feature;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{

    use RefreshDatabase;

    const CART_STRUCTURE = [
        'content' => [
            '*' => [
                'rowId',
                'id',
                'name',
                'qty',
                'price',
                'subtotal',
                'image',
            ],
        ],
        'count',
        'subtotal',
        'total',
    ];

    const EMPTY_CART = [
        'content' => [],
        'count' => 0,
        'subtotal' => 0,
    ];


    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_get_cart_content(): void
    {
        $product1 = Product::all()->random(1)->first();
        $product2 = Product::all()->random(1)->first();
        $expectedTotal = $product1->price + $product2->price;
        Cart::add($product1);
        Cart::add($product2);

        $response = $this->get('/api/cart');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::CART_STRUCTURE);

        $response->assertJson([
            'count' => 2,
            'subtotal' => $expectedTotal,
        ]);
    }

    public function test_get_empty_cart(): void
    {
        $response = $this->get('/api/cart');

        $response->assertStatus(200);
        $response->assertJson(self::EMPTY_CART);
    }

    public function test_add_item_to_cart(): void
    {
        $product = Product::all()->random(1)->first();

        $response = $this->patch('/api/cart/addItem', [
            'id' => $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(self::CART_STRUCTURE);
        $response->assertJson([
            'count' => 1,
            'subtotal' => $product->price,
        ]);
    }

    public function test_remove_item_from_cart(): void
    {
        $product1 = Product::all()->random(1)->first();
        $product2 = Product::all()->random(1)->first();
        // removing product 2, so total is only price of product 1
        $expectedTotal = $product1->price;
        Cart::add($product1);
        $cartItem = Cart::add($product2);

        $response = $this->patch('/api/cart/removeItem', [
            'rowId' => $cartItem->rowId,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(self::CART_STRUCTURE);
        $response->assertJson([
            'count' => 1,
            'subtotal' => $expectedTotal,
        ]);
    }

    public function test_empty_cart(): void
    {
        $product1 = Product::all()->random(1)->first();
        $product2 = Product::all()->random(1)->first();
        Cart::add($product1);
        Cart::add($product2);

        $response = $this->delete('/api/cart');

        $response->assertStatus(200);
        $response->assertJson(self::EMPTY_CART);
    }
}
