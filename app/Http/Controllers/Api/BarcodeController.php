<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    //
    public function index(){
        return view("barcode");
    }
}
