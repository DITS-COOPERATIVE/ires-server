<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "orders";

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'price',
        'points',
        'status',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id');
    }
}
