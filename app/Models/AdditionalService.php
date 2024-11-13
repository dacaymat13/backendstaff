<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdditionalService extends Model
{
    use HasFactory, Notifiable, HasApiTokens ;

    protected $primaryKey = 'AddService_ID';
    protected $fillable = [
        'Transac_ID',
        'AddService_name',
        'AddService_price'
    ];
}
