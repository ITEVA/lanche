<?php

namespace App\Http\Controllers;

use App\User;
use App\Permissao;
use App\Produto;
use App\Cardapio;
use App\Pedido;
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
        if($this->checkPermissao()) return redirect('perfil/'.Auth::user()->id);
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $usuarios = User::where($this->getFilter())->get();
        $permissoes = Permissao::where($this->getFilter())->get();
        $produtos = Produto::where($this->getFilter())->get();
        $cardapios = Cardapio::where($this->getFilter())->get();
        $pedidos = Pedido::where($this->getFilter())->get();

        return view('adm.inicio.paginaInicial')
            ->with('usuarios', $usuarios)
            ->with('permissoes', $permissoes)
            ->with('produtos', $produtos)
            ->with('cardapios', $cardapios)
            ->with('pedidos', $pedidos)
            ->with('itensPermitidos', $itensPermitidos);
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
