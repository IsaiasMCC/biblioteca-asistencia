<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credencial extends Model
{
    protected $table = 'credenciales';
    protected $fillable = [
        'codigo',
        'foto_qr',
        'fecha_emicion',
        'fecha_expiracion',
        'estado',
        'usuario_id',
        'gestion_id',

    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }
}
