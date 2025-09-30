<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemCategory;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $fillable = [
        'item_name',
        'price',
        'qty',
        'description',
        'category_id'
    ];

    // Item -> Category (Many to One)
    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }
}
