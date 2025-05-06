<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurante_id',
        'nombre_menu',
        'nombre_plato',
        'descripcion_plato',
        'precio'
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'restaurante_id');
    }
}