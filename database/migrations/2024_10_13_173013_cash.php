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
        Schema::create('cash', function (Blueprint $table){
            $table->id('Cash_ID'); //optional: change the size of this as it should be int(5). (Alter table cash modify Cash_ID int(5) auto_increment;)
            $table->integer('Admin_ID')->autoIncrement(false);  //optional: change the size of this as it should be int(5). (Alter table cash modify Admin_ID int(5) not null;)
            $table->integer('Staff_ID')->autoIncrement(false); //optional: change the size of this as it should be int(5). (Alter table cash modify Staff_ID int(5) not null;)
            $table->double('Initial_amount'); //(Alter table cash modify Initial_amount double(10,2) not null;)
            $table->double('Remittance'); //(Alter table cash modify Remittance double(10,2);)
            $table->datetime('Datetime_InitialAmo');
            $table->datetime('Datetime_Remittance'); //(Alter table cash modify Datetime_Remittance datetime null;
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
