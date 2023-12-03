<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'total',
        'quantity',
        'internal_note',
        "customer_note",
        'discount',
    ];

    protected $with = ['products'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(
            "price",
            "qty",
            "points",
            "sub_total",
            "discount"
        );
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
