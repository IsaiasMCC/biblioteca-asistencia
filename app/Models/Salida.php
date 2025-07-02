<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $table = 'salidas';
    protected $fillable = [
        'hora',
        'fecha',
        'credencial_id',
        'sala_id',
    ];
}
