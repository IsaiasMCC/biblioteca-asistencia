<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';
    protected $fillable = [
        'hora',
        'fecha',
        'credencial_id',
        'sala_id',
        'created_at',
    ];

    public function credencial()
    {
        return $this->belongsTo(Credencial::class, 'credencial_id');
    }
}
