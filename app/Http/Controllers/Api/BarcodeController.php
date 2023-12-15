<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
class BarcodeController extends Controller
{
    //
    public function generate(Request $barcode){
        // This will output the barcode as HTML output to display in the browser
        $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
        $generated_barcode = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);

        return $generated_barcode;
    }
}
