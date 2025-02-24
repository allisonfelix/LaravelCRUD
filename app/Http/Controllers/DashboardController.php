<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        return view('index', $this->dashboardService->getFullData());
    }

    public function indexvars()
    {
        $usuarios = $this->dashboardService->getUsuarios();
        $albuns = $this->dashboardService->getAlbuns();
        $musicas = $this->dashboardService->getMusicas();

        return compact('usuarios','albuns','musicas');
    }

    public function userdash()
    {
        return view('usuario_dashboard', $this->dashboardService->getFullData());
    }

    public function admin() {
        $usuarios = $this->dashboardService->getUsuarios();
        $albuns = $this->dashboardService->getAlbuns();
        $musicas = $this->dashboardService->getMusicas();

        return view('index', $this->dashboardService->getFullData());
    }

    public function auth(Request $request)
    {
        $credenciais = $request->validate([
            'usuario' => ['required'],
            'senha' => ['required'],
        ]);

        if(Auth::attempt([
        'usuario' => $request->usuario, // ← Campo 'usuario'
        'password' => $request->senha   // ← Campo 'senha' (já ajustado para hash)
    ])) {
            $request->session()->regenerate();
            $usuario = Auth::user();
            return redirect()->route($usuario->is_admin ? 'dashboard.admin' : 'dashboard.userdash');
        } else{
            return redirect()->back()->with('erro','Usuário e/ou senha inválido(s).');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function exibeForm(){
        return view('login');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->route($usuario->is_admin ? 'dashboard.admin' : 'dashboard.userdash');
    }
}
