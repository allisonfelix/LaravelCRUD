<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Pega todos os usuários
        return view('index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Aqui você pode retornar a view se for necessário
        return view('user.create');
    }

    /**
     * Armazenar um usuário novo no banco de dados.
     */
    public function store(Request $request)
    {   
        // Validação dos dados recebidos
        $validateData = $request->validate([
            'nomeUsuario' => 'required|string|max:255',
            'dataNascimentoUsuario' => 'required|date',
            'sexoUsuario' => 'required|string',
            'usuarioUsuario' => 'required|string|unique:usuarios,usuario|max:255',
            'senhaUsuario' => 'required|string|min:6'
        ]);

        // Cria o usuário
        $user = new User();
        $user->nome = $request->input('nomeUsuario');
        $user->data_nascimento = $request->input('dataNascimentoUsuario');
        $user->sexo = $request->input('sexoUsuario');
        $user->usuario = strtolower($request->input('usuarioUsuario'));
        $user->senha = $request->input('senhaUsuario'); //A senha é criptografada via Hash no model

        $user->save();

        return redirect()->back()->with('alert', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function search(Request $request)
    {
        $query = $request->query('query'); // Corrigindo o acesso ao parâmetro

        if ($query) {
            $resultados = User::where('nome', 'LIKE', "%{$query}%")->get();
        } else {
            $resultados = User::all();
        }

        return response()->json($resultados);
    }

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|string',
            'usuario' => 'required|string|max:255|unique:usuarios,usuario,'.$user->id
        ]);
        
        $user->update([
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'usuario' => $request->usuario,
        ]);

        if($request->senha != ""){
            $user->update([
                'senha' => $request->senha,
            ]);
        }

        return response()->json(['success' => 'Usuário atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('alert', 'Usuário excluído com sucesso!');
    }
}
