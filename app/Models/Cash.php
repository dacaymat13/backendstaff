<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;

    protected $primaryKey = 'Cash_ID';
    protected $fillable = [
        'Admin_ID',
        'Staff_ID',
        'Initial_amount',
        'Remittance',
        'Datetime_InitialAmo',
        'Datetime_Remittance'
    ];
}
