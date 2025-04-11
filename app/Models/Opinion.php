<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'restaurante_id',
        'comentario',
        'calificacion',
        'fecha'
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