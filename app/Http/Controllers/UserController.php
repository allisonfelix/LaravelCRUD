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
        return response()->json($users);
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // Validação dos dados recebidos
        $request->validate([
            'nomeUsuario' => 'required|string|max:255',
            'dataNascimentoUsuario' => 'required|date',
            'sexoUsuario' => 'required|string',
            'usuarioUsuario' => 'required|string|unique:usuarios,usuario|max:255',
            'senhaUsuario' => 'required|string|min:6',
        ]);

        // Cria o usuário
        $user = new User();
        $user->nome = $request->input('nomeUsuario');
        $user->data_nascimento = $request->input('dataNascimentoUsuario');
        $user->sexo = $request->input('sexoUsuario');
        $user->usuario = $request->input('usuarioUsuario');

        $user->senha = bcrypt($request->input('senhaUsuario')); // Criptografa a senha

        $user->save();

        dd($user);

        //return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id); // Busca o usuário pelo ID
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id); // Busca o usuário
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validação dos dados para update
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|string',
            'usuario' => 'required|string|max:255|unique:usuarios,usuario,' . $user->id,
            'senha' => 'nullable|string|min:6',
        ]);

        $user->update([
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'usuario' => $request->usuario,
            'senha' => $request->senha ? bcrypt($request->senha) : $user->senha, // Atualiza a senha se fornecida
        ]);

        return response()->json(['message' => 'Usuário atualizado com sucesso!', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso!']);
    }
}
