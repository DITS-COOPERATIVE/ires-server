<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('gender');
            $table->string('email');
            $table->string('mobile_no');
            $table->string('birth_date');
            $table->string('address');
            $table->string('privilege');
            $table->float('points');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropSoftDeletes(); 
        });
        Schema::dropIfExists('customers');
    }
};
