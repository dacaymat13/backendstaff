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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('Admin_ID'); //optional: change the size of this as it should be int(5). (ALter table admins modify Admin_ID int(5) auto_increment;)
            $table->string('Admin_lname');
            $table->string('Admin_fname');
            $table->string('Admin_mname');
            $table->string('Admin_image', 255);
            $table->date('Birthdate');
            $table->string('Phone_no', 11);
            $table->string('Address', 150);
            $table->string('Role');
            $table->string('Email')->unique();
            $table->string('Password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
