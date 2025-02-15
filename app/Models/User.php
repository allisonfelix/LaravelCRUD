<?php

namespace App\Models;
use App\Models\Album;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    protected $fillable = [
        'nome',
        'data_nascimento',
        'sexo',
        'usuario',
        'senha'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'senha', // Mudado de 'password' para 'senha'
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Isso não é necessário porque 'senha' é o campo usado
        ];
    }

    /**
     * Hash the password before saving it to the database.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Verifica se a senha está definida, se não, a define e faz o hash
            if ($user->senha) {
                $user->senha = Hash::make($user->senha);
            }
        });
    }
}
