<?php

namespace App\Services;

use App\Models\User;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getUsuarios()
    {
        $user = Auth::user();

        return $user->is_admin 
            ? User::all() 
            : User::where('id', $user->id)->get();
    }

    public function getAlbuns()
    {
        $user = Auth::user();

        return $user->is_admin 
            ? Album::all() 
            : Album::where('user_id', $user->id)->get();
    }

    public function getMusicas()
    {
        $user = Auth::user();

        return $user->is_admin 
            ? Song::all() 
            : Song::where('user_id', $user->id)->get();
    }

    public function getFullData()
    {
        return [
            'usuarios' => $this->getUsuarios(),
            'albuns' => $this->getAlbuns(),
            'musicas' => $this->getMusicas(),
        ];
    }
}
