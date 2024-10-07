<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with('products', 'customer')->paginate(50), 200);
    }

    public function store(OrderRequest $request)
    {
        $order = Order::create(['customer_id' => $request->customer_id]);

        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        $order->load('products', 'customer');

        event(new OrderCreated($order));

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        $order->load(['products', 'customer']);
        return response()->json($order);
    }

    public function update(OrderRequest $request, Order $order)
    {
        $order->update([
            'customer_id' => $request->customer_id,
        ]);

        $products = [];
        foreach ($request->products as $product) {
            $products[$product['id']] = ['quantity' => $product['quantity']];
        }
        $order->products()->sync($products);

        return response()->json($order->load('products', 'customer'), 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
