<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    // Definir a tabela associada
    protected $table = 'musicas';

    // Colunas que podem ser preenchidas em massa
    protected $fillable = ['nome', 'duracao', 'album_id', 'ordem'];

    // Definir a relação com o modelo Album (muitas músicas pertencem a um álbum)
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
