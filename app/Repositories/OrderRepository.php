<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAll()
    {
        return Order::with('concessions')->latest()->get();
    }

    public function create(array $data)
{
    // Validate required fields
    if (!isset($data['user_id'])) {
        throw new \Exception("User ID is required to create an order");
    }

    $order = Order::create([
        'send_to_kitchen_time' => $data['send_to_kitchen_time'],
        'status' => $data['status'],
        'user_id' => $data['user_id']
    ]);

   
    if (isset($data['concessions'])) {
        $concessionsWithQuantities = [];
        
        foreach ($data['concessions'] as $concessionId) {
            $concessionsWithQuantities[$concessionId] = ['quantity' => 1];
        }
        
        $order->concessions()->sync($concessionsWithQuantities);
    }

    return $order;
}

    public function find($id)
    {
        return Order::with('concessions')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function delete($id)
    {
        return Order::destroy($id);
    }
    public function getOrdersToSendToKitchen()
    {
        return Order::with(['concessions', 'user'])
                    ->whereIn('status', ['In Kitchen', 'In-Progress'])
                    ->orderBy('send_to_kitchen_time', 'desc')
                    ->get();
    }

public function updateStatus($orderId, $status)
{
    $order = Order::findOrFail($orderId);
    $order->status = $status;
    $order->save();
    return $order;
}

}