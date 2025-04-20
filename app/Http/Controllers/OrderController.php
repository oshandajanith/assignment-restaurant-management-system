<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\ConcessionRepositoryInterface;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
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

    public function AddOrder()
    {
        $concessions = $this->concessionRepo->all();
        return view('orders.create-order', compact('concessions'));
    }

    public function StoreOrder(Request $request)
    {
       
        $validated = $request->validate([
            'concessions' => 'required|array|min:1',
            'concessions.*' => 'exists:concessions,id',
            'send_time' => 'required|date',
            'status' => 'required|string|in:Pending,In-Progress,Completed',
        ]);
    
        try {
           
            $order = $this->orderRepo->create([
                'concessions' => $validated['concessions'],
                'send_to_kitchen_time' => $validated['send_time'],
                'status' => $validated['status'],
                'user_id' => auth()->id() 
            ]);
    
            $notification = [
                'message' => 'Order created successfully.',
                'alert-type' => 'success'
            ];
    
            return redirect()->back()->with($notification);
    
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error creating order: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
    
            return redirect()->back()->withInput()->with($notification);
        }
    }
    public function ManageOrder()
    {
        $concessions = $this->concessionRepo->all();
        $orders = $this->orderRepo->getAll();
        return view('orders.manage-order', compact('orders','concessions'));
    }
  
    public function sendToKitchen(Order $order)
{
    try {
        // Validate order can be sent to kitchen
        if ($order->status === 'Completed') {
            $notification = [
                'message' => 'Cannot send completed order to kitchen',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        if ($order->status === 'In Kitchen') {
            $notification = [
                'message' => 'Order is already in kitchen',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notification);
        }

       
        $this->orderRepo->update($order->id, [
            'status' => 'In-Progress',
            'send_to_kitchen_time' => now(),
        ]);

        
        Log::info("Order #{$order->id} sent to kitchen", [
            'user_id' => auth()->id(),
            'time' => now(),
        ]);


        $notification = [
            'message' => 'Order successfully sent to kitchen',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);

    } catch (\Exception $e) {
        Log::error("Failed to send order #{$order->id} to kitchen: " . $e->getMessage());

        $notification = [
            'message' => 'Failed to update order status. Please try again.',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }
}
public function destroy($id)
{
    $this->orderRepo->delete($id);
    $notification = [
        'message' => ' order Deleted successfully ',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}
}