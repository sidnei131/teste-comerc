<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id'];
    protected $appends = ['total_price'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getTotalPriceAttribute()
    {
        return $this->products->sum(function ($product) {
            return $product->pivot->quantity * $product->price;
        });
    }
}
