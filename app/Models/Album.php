<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    // Definir a tabela associada (opcional)
    protected $table = 'albuns';

    // Colunas que podem ser preenchidas em massa
    protected $fillable = ['nome', 'ano', 'artista', 'user_id'];

    // Definir a relação com o modelo Song (um álbum tem muitas músicas)
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
