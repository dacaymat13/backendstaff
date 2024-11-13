<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'Transac_ID';
    public $incrementing = true;
    // protected $keyType = 'bigint';

    protected $fillable = [
        "Cust_ID",
        "Admin_ID",
        "Transac_date",
        "Transac_status",
        "Tracking_number",
        "Received_datetime",
        "Released_datetime"
    ];
}
