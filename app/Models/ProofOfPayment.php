<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofOfPayment extends Model
{
    use HasFactory;

    protected $primaryKey = 'Proof_ID';
    protected $fillable = [
        'Payment_ID',
        'Proof_filename',
        'Upload_datetime'
    ];
}
