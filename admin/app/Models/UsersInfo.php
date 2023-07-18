<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    use HasFactory;

    protected $table = "usersinfo";

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'birth_date',
        'mobile_no',
        'address'
    ];
}
