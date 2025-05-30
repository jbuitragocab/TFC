<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Menu extends Model
{
    use HasFactory;

     protected $primaryKey = 'id_menu';

    protected $fillable = [
        'restaurante_id',
        'nombre_menu',
        'descripcion_menu',
        'precio'
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'restaurante_id',);
    }
}