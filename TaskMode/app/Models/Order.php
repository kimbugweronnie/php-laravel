<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $fillable = ['customer_name', 'status','completed_at','items','total_amount','itemsCount'];

    public function cart_items()
    {
        return $this->hasMany(CartItem::class);
    }

    
}
