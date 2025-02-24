<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Song;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albuns = Album::all();
        return view('index', compact('albuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albuns = Album::all();
        dd($albuns);
        return view('index', compact('albuns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $album->user_id = $request->input('sid');
        $album->save();

        return redirect()->back()->with('alert', 'Álbum cadastrado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function search(Request $request)
    {
        $query = $request->query('query');
        $id = Auth::id(); // Maneira mais curta de obter o ID do usuário autenticado

        $resultados = Album::where('user_id', $id) // Filtra apenas os álbuns do usuário autenticado
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('nome', 'LIKE', "%{$query}%");
            })
            ->get();

        return response()->json($resultados);
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
    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
    
        $request->validate([
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer|max:' . date('Y'),
            'artista' => 'required|string|max:255',
        ]);

        $album->update([
            'nome' => $request->nome,
            'ano' => $request->ano,
            'artista' => $request->artista
        ]);

        return response()->json(['success' => 'Álbum atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Garantir que o ID seja um número inteiro
        $id = intval($id);

        $album = Album::findOrFail($id);

        // Excluir todas as músicas relacionadas ao álbum
        Song::where('album_id', $id)->delete();

        // Excluir o álbum
        $album->delete();

        // Resposta JSON para Ajax
        return response()->json(['success' => true]);
    }
}
