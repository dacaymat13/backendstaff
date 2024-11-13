<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Model
{
    use HasFactory, Notifiable, HasApiTokens ;
    protected $fillable = [
        "Admin_lname",
        "Admin_fname",
        "Admin_mname",
        "Admin_image",
        "Birthdate",
        "Phone_No",
        "Address",
        "Role"
    ];

}
