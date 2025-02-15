<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albuns = Album::all();
        return view('albuns.index', compact('albuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('albuns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica os dados do formulário para garantir que estão corretos
        //dd($request->all());

        // Validação dos dados do formulário
        $request->validate([
            'nomeAlbum' => 'required|string|max:255',
            'ano_lancamento' => 'required|integer|min:1900|max:' . date('Y'),
            'artistaAlbum' => 'required|string|max:255',
        ]);

        // Criando um novo álbum usando o método save()
        $album = new Album();
        $album->nome = $request->input('nomeAlbum');
        $album->ano = $request->input('ano_lancamento');
        $album->artista = $request->input('artistaAlbum');
        $album->save();
        
    }




    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return view('albuns.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        return view('albuns.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'nomeAlbum' => 'required|string|max:255',
            'ano_lancamento' => 'required|integer|min:1900|max:' . date('Y'),
            'artistaAlbum' => 'required|string|max:255',
        ]);

        $album->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        $album->delete();
    }
}
