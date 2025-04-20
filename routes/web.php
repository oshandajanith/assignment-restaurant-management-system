<?php

use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//concession

Route::get('/addconcession',[ConcessionController::class,'AddConcession'])->name('concession.add');
Route::post('/store/concession', [ConcessionController::class, 'StoreConcession'])->name('concession.store');
Route::get('/viewconcession/{id}', [ConcessionController::class, 'viewConcession'])->name('concession.view');
Route::put('/updateconcessions/{id}', [ConcessionController::class, 'UpdateConcession'])->name('concession.update');
Route::delete('concessions/{id}', [ConcessionController::class, 'destroy'])->name('concessions.destroy');

//Order

Route::get('/addorder',[OrderController::class,'AddOrder'])->name('order.add');
Route::post('/orders', [OrderController::class, 'StoreOrder'])
     ->middleware('auth')
     ->name('order.store');
Route::get('/manage',[OrderController::class,'ManageOrder'])->name('order.manage');
Route::post('/orders/{order}/send-to-kitchen', [OrderController::class, 'sendToKitchen'])->name('orders.send-to-kitchen');
Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

//kitchen

Route::prefix('kitchen')->group(function () {
    Route::get('/', [KitchenController::class, 'kitchenView'])->name('kitchen.index');
    Route::post('/orders/{id}/update-status', [KitchenController::class, 'updateOrderStatus'])->name('orders.update-status');
});
//dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');
