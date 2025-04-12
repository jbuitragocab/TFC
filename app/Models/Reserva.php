<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Reserva.php
class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'restaurante_id',
        'fecha',
        'num_personas',
        'importe_reserva'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}