<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Admins as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens, HasFactory, Notifiable ;

    protected $primaryKey = 'Admin_ID';
    public $incrementing = true;
    // protected $table = 'admins';
    // protected $keyType = 'bigint';

    protected $fillable = [
        "Admin_lname",
        "Admin_fname",
        "Admin_mname",
        "Admin_image",
        "Birthdate",
        "Phone_no",
        "Address",
        "Role",
        "Email",
        "Password"
    ];
}
