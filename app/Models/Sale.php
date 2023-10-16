<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = "sales";

    protected $fillable = [
        'order_id',
        'total_price',
        'total_points',
    ];

    public function orders()
    {
        return $this->hasOne(Orders::class, 'id', 'order_id');
    }
    
}
