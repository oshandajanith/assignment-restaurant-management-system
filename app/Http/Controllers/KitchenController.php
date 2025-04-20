<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\ConcessionRepositoryInterface;


class KitchenController extends Controller
{
    protected $orderRepo;
    protected $concessionRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        ConcessionRepositoryInterface $concessionRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->concessionRepo = $concessionRepo;
    }
    public function kitchenView()
{
    $orders = $this->orderRepo->getOrdersToSendToKitchen()
                ->load(['concessions', 'user']); 
    
    foreach ($orders as $order) {
        if ($order->status !== 'Completed') {
            $this->orderRepo->updateStatus($order->id, 'In-Progress');
        }
    }

    return view('kitchen.kitchen', compact('orders'));
}
    
    public function updateOrderStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:In-Progress,Completed',
        ]);
    
        $this->orderRepo->updateStatus($id, $validated['status']);

        $notification = [
            'message' => 'Order status updated',
            'alert-type' => 'success'
        ];

    
        return redirect()->back()->with($notification);
    }
    
}
