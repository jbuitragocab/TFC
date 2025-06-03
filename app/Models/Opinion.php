<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'restaurante_id', 'id_restaurante');
    }
}