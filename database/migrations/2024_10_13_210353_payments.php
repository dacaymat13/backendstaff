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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('Payment_ID'); //optional: change the size of this as it should be int(7). (ALter table payments modify Payment_ID int(7) auto_increment;)
            $table->integer('Admin_ID')->autoIncrement(false); //optional: change the size of this as it should be int(5). (ALter table payments modify Admin_ID int(5) not null;)
            $table->integer('Transac_ID')->autoIncrement(false); //optional: change the size of this as it should be int(7). (ALter table payments modify Transac_ID int(7) not null;)
            $table->double('Amount'); //(Alter table payments modify Amount double(10,2) not null;)
            $table->string('Mode_of_Payment');
            $table->datetime('Datetime_of_Payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
