<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'send_to_kitchen_time',
        'status',
        'user_id',
        'concession_ids'
    ];

    public function concessions()
    {
        return $this->belongsToMany(Concession::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalCostAttribute()
    {
        if ($this->concessions->isEmpty()) {
            return 0;
        }

        return $this->concessions->sum(function ($concession) {
            return $concession->pivot->quantity * $concession->price;
        });
    }
}