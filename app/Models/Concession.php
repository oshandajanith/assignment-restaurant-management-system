<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
    

public function index()
{
    $totalIncome = Concession::sum('price'); // Sum all concession prices
    
    return view('dashboard', compact('totalIncome'));
}
}