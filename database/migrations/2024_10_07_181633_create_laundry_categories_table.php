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
        Schema::create('laundry_categories', function (Blueprint $table) {
            $table->id('Categ_ID'); //optional: change the size of this as it should be int(4). (ALter table laundry_categories modify Categ_ID int(4) auto_increment;)
            $table->string('Category', 50);
            $table->double('Price'); //(ALter table laundry_categories modify Price double(10,2) not null;)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_categories');
    }
};
