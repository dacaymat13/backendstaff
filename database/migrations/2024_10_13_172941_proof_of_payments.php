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
        Schema::create('proof_of_payments', function (Blueprint $table){
            $table->id('Proof_ID'); //optional: change the size of this as it should be int(7). (ALter table proof_of_payments modify Proof_ID int(7) auto_increment;)
            $table->integer('Payment_ID')->autoIncrement(false); //optional: change the size of this as it should be int(7). (ALter table proof_of_payments modify Payment_ID int(7) not null;)
            $table->string('Proof_filename');
            $table->datetime('Upload_datetime');
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
