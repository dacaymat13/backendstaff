<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'Cust_ID';
    public $incrementing = true;
    // protected $keyType = 'bigint';

    protected $fillable = [
        "Cust_lname",
        "Cust_fname",
        "Cust_mname",
        "Cust_image",
        // "Birthdate",
        "Cust_phoneno",
        "Cust_address",
        "Cust_email",
        "Cust_password"
    ];
}


// {
//     "Cust_lname": "",
//     "Cust_fname": "",
//     "Cust_mname": "",
//     "Cust_image": "",
//     "Cust_phoneno": "",
//     "Cust_address": "",
//     "Cust_email": "",
//     "Cust_password": "",
//     "Cust_password_confirmation":
// }
