<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'contrasena',
        'fecha_registro',
        'cuenta_bancaria',
        'admin'
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function opiniones()
    {
        return $this->hasMany(Opinion::class);
    }
}