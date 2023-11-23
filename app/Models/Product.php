<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "products";

    protected $fillable = [
        'name',
        'code',
        'model',
        'price',
        'quantity',
        'points',
        'image',
        'category',
    ];
    public function customers()
    {
        return $this->belongsToMany(Product::class, 'customer_product', 'product_id', 'customer_id');
    }
}
