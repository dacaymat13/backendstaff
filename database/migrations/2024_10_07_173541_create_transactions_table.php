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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('Transac_ID'); //optional: change the size of this as it should be int(7). (ALter table transactions modify Transac_ID int(7) auto_increment;)
            $table->integer('Cust_ID'); //optional: change the size of this as it should be int(7). (ALter table transactions modify Cust_ID int(7) not null;)
            $table->integer('Admin_ID'); //optional: change the size of this as it should be int(5). (ALter table transactions modify Admin_ID int(5) not null;)
            $table->datetime('Transac_date');
            $table->string('Transac_status', 15);
            $table->string('Tracking_number', 13);
            $table->datetime('Pickup_datetime'); // (Alter table transactions modify Pickup_datetime datetime null;)
            $table->datetime('Delivery_datetime'); // (Alter table transactions modify Delivery_datetime datetime null;)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
