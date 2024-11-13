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
        Schema::create('additional_services', function (Blueprint $table){
            $table->id('AddService_ID'); //optional: change the size of this as it should be 7. (Alter table additional_services modify AddService_ID int(7) auto_increment;)
            $table->integer('Transac_ID')->autoIncrement(false); //optional: change the size of this as it should be 7. (Alter table additional_services modify Transac_ID int(7) not null;)
            $table->string('AddService_name', 100);
            $table->double('AddService_price'); //(Alter table additional_services modify AddService_price double(10,2);)
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
