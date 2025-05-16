<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'horario'
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function opiniones()
    {
        return $this->hasMany(Opinion::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'restaurante_id', 'id_restaurante');
    }
}