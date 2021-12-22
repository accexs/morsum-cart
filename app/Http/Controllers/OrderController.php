<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{


    /**
     * @throws \Throwable
     */
    public function store(OrderService $orderService): JsonResource
    {
        $order = $orderService->createNewOrder();
        return OrderResource::make($order);
    }

}
