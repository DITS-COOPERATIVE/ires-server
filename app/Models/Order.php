<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "customer_product";
    protected $fillable = [
        'customer_id',
        'product_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class,'id','product_id');
    }
    public function customers()
    {
        return $this->belongsTo(Customer::class,'id','customer_id');
    }
}
