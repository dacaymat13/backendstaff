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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id('Expense_ID'); //optional: change the size of this as it should be int(5). (ALter table expenses modify Expense_ID int(5) auto_increment;)
            $table->integer('Admin_ID', 5)->autoIncrement(false); //optional: change the size of this as it should be int(5). (ALter table expenses modify Admin_ID int(5) not null;)
            $table->double('Amount', 10, 2); // (Alter table expenses modify Amount double(10,2) not null;)
            $table->text('Desc_reason');
            $table->string('Receipt_filenameimg');
            $table->datetime('Datetime_taken');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
