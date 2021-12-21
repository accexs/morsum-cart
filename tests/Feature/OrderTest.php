<?php

namespace Tests\Feature;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{

    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Create an order.
     *
     * @return void
     */
    public function test_order_creation(): void
    {
        $product = Product::first();
        $qty = 2;
        $expectedTotal = $product->price * $qty;

        // add items to cart
        Cart::add($product, 2);
        Cart::store('morsum_cart');

        $response = $this->postJson('/api/orders');

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'total',
            'created_at',
            'updated_at',
            'products' => [],
        ]);
        $response->assertJson([
            'total' => $expectedTotal,
        ]);
    }

    /**
     * Trying to create an order with an empty cart.
     *
     * @return void
     */
    public function test_create_order_with_empty_cart(): void
    {
        $response = $this->postJson('/api/orders');
        $response->assertStatus(406);
        $response->assertJson([
            'error' => 'Cart is empty, cannot create order',
        ]);
    }
}
