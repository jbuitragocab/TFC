<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable = [
        'restaurante_id',
        'identificador',
        'capacidad',
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'restaurante_id', 'id_restaurante');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'mesa_id');
    }
}