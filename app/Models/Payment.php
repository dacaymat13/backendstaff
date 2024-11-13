<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primayKey = 'Payment_ID';
    protected $fillable = [
        'Admin_ID',
        'Transac_ID',
        'Amount',
        'Mode_of_Payment',
        'Datetime_of_Payment'
    ];
}
