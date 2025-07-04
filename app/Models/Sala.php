<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'salas';
    protected $fillable = [
        'nombre',
        'capacidad',
        'ubicacion',
        'descripcion',
        'estado'
    ];
}
