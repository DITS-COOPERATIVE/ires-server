<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'gender',
        'email',
        'mobile_no',
        'address',
        'privilege',
        'points',
        'image',
        'barcode',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'customer_product', 'customer_id', 'product_id');
    }


    /**
     * Get all of the reservations for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
