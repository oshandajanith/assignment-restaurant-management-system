<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
{
    $concessionCount = Concession::count();
    $totalIncome = Concession::sum('price'); 
    $totalOrders = Order::count();
    $totalUsers = User::count();

    
    
    return view('dashboard',compact('concessionCount', 'totalIncome','totalOrders', 'totalUsers'));
    
}
}
