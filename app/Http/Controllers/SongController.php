<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Album;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $musicas = Song::all();  // Buscar todas as músicas
        $albuns = Album::all(); // Buscar todos os álbuns

        return compact('musicas', 'albuns'); 
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {   
        $musicas = Song::all();  // Buscar todas as músicas
        $albuns = Album::all(); // Pegando todos os álbuns
        return compact('musicas', 'albuns'); // Corrigindo o nome da variável
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomeMusica' => 'required|string|max:255',
            'duracaoMusica' => 'required|string|min:5|max:5',
            'albumMusica' => 'required|string|max:255',
            'numeroMusica' => 'integer|min:1',
        ]);

        // Pega o valor de 'duracaoMusica' no formato "mm:ss"
        $duracao = $request->input('duracaoMusica');
    
        // Divide o valor de "mm:ss" em minutos e segundos
        list($minutos, $segundos) = explode(':', $duracao);

        // Converte para segundos
        $totalSegundos = ($minutos * 60) + $segundos;

        // Criando um novo álbum usando o método save()
        $musica = new Song();
        $musica->nome = $request->input('nomeMusica');
        $musica->duracao = $totalSegundos;
        $musica->album_id = $request->input('albumMusica');
        $musica->ordem = (int)$request->input('numeroMusica');
        $musica->user_id = Auth::user()->id;

        $musica->save();

        return redirect()->back()->with('alert', 'Música cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function search(Request $request)
    {
        $query = $request->query('query');
        $id = Auth::user()->id;

        $resultados = Song::with('album')
            ->where('user_id', $id) // Filtra pelo usuário autenticado
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('nome', 'LIKE', "%{$query}%");
            })
            ->get();

        return response()->json($resultados);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $musica = Song::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'duracao' => 'required|string|min:5|max:5',
            'album_id' => 'required|string|max:255',
            'ordem' => 'integer|min:1',
        ]);

        // Pega o valor de 'duracaoMusica' no formato "mm:ss"
        $duracao = $request->input('duracao');
    
        // Divide o valor de "mm:ss" em minutos e segundos
        list($minutos, $segundos) = explode(':', $duracao);

        // Converte para segundos
        $totalSegundos = ($minutos * 60) + $segundos;

        $musica->update([
            'nome' => $request->nome,
            'duracao' => $totalSegundos,
            'album_id' => $request->album_id,
            'ordem' => $request->ordem,
        ]);

        return response()->json(['success' => 'Usuário atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $musica = Song::findOrFail($id);
        $musica->delete();

        return redirect()->back()->with('alert', 'Música excluída com sucesso!');
    }
}
