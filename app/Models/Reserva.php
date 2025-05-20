<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Reserva.php
class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'restaurante_id',
        'mesa_id',
        'fecha',
        'num_personas',
        'hora',
        'importe_reserva'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }

    public function mesa() 
    {
        return $this->belongsTo(Mesa::class);
    }
}