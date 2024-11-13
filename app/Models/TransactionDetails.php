<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'TransacDet_ID';

    protected $fillable = [
        'Categ_ID',
        'Transac_ID',
        'Qty',
        'Weight',
        'Price'
    ];
}
