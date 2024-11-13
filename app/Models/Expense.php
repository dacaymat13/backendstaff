<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Expense extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'Expense_ID';
    public $incrementing = true;
    // protected $keyType = 'bigint';

    protected $fillable = [
        "Admin_ID",
        "Amount",
        "Desc_reason",
        "Receipt_filenameimg",
        "Datetime_taken"
    ];
}
