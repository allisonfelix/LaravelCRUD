<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios'; // Nome da tabela no banco
    protected $username = 'usuario'; // Campo de autenticação

    protected $casts = [
        'is_admin' => 'boolean', // Faz com que 0 seja false e 1 seja true
    ];

    protected $fillable = [
        'nome',
        'data_nascimento',
        'sexo',
        'usuario',
        'senha'
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    // Hash automático da senha
    public function setSenhaAttribute($value) {
        $this->attributes['senha'] = Hash::make($value);
    }

    // Sobrescreva para autenticação via 'usuario'
    public function findForPassport($username) {
        return $this->where('usuario', $username)->first();
    }

    // Sobrescreva para usar 'senha' como campo de senha
    public function getAuthPassword() {
        return $this->senha;
    }

    // Verifica se é admin
    public function isAdmin() {
        return $this->is_admin; // Certifique-se de que a coluna 'is_admin' existe
    }

    // Relacionamento com álbuns (se necessário)
    public function albums() {
        return $this->hasMany(Album::class);
    }
}
