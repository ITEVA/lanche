<?php

namespace App\Http\Controllers;

use App\User;
use App\Permissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InicioController extends AbstractCrudController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $usuarios = User::where($this->getFilter())->get();
        $permissoes = Permissao::where($this->getFilter())->get();

        return view('adm.inicio.paginaInicial')
            ->with('permissoes', $permissoes)
            ->with('usuarios', $usuarios)
            ->with('itensPermitidos', $itensPermitidos);
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
