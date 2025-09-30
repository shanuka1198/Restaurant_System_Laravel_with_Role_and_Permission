<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Item;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'status',
        'total_amount'
    ];

    // Order -> Customer (Many to One)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Order -> Items (Many to Many)
    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}