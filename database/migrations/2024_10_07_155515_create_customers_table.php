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
            $table->id('Cust_ID'); //optional: change the size of this as it should be int(7). (ALter table customers modify Cust_ID int(7) auto_increment;)
            $table->string('Cust_lname');
            $table->string('Cust_fname');
            $table->string('Cust_mname');
            $table->string('Cust_phoneno', 11);
            $table->string('Cust_address', 150);
            $table->string('Cust_image', 255);
            $table->string('Cust_email', 50)->unique();
            $table->string('Cust_password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
