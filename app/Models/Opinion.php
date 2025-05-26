<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Añadir esta línea
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $table = 'opiniones';
    use HasFactory;

    protected $primaryKey = 'id_opinion';

    protected $fillable = [
        'usuario_id',
        'restaurante_id',
        'comentario',
        'calificacion',
        'fecha'
    ];

    public function usuario()
    {
        // Relación con el modelo User. Asumimos que User tiene una clave primaria 'id_usuario'.
        // Si la clave primaria de tu tabla 'users' es 'id', cambia 'id_usuario' por 'id'.
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }

    public function restaurante()
    {
        // Relación con el modelo Restaurante.
        return $this->belongsTo(Restaurante::class, 'restaurante_id', 'id_restaurante');
    }
}