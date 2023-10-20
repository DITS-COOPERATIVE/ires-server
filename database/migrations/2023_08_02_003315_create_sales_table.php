<?php

use App\Models\Products;
use App\Models\Customers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->float('total_price');
            $table->float('total_points');
            $table->timestamps();
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
        Schema::table('sales', function (Blueprint $table) {
            $table->dropSoftDeletes(); 
        });
    }
};
