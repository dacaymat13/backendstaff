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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id('TransacDet_ID'); //optional: change the size of this as it should be int(5). (ALter table transaction_details modify TransacDet_ID int(7) auto_increment;)
            $table->integer('Categ_ID', 4)->autoIncrement(false); //optional: change the size of this as it should be int(4). (ALter table transaction_details modify Categ_ID int(4) not null;)
            $table->integer('Transac_ID', 7)->autoIncrement(false); //optional: change the size of this as it should be int(7). (ALter table transaction_details modify Transac_ID int(7) not null;)
            $table->integer('Qty', 4);
            $table->double('Weight'); //(ALter table transaction_details modify Weight double(10,2);)
            $table->double('Price'); //(ALter table transaction_details modify Price double(10,2);)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
