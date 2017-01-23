<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Produto;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ProdutoController extends AbstractCrudController
{
    private $filtro = [];

    public function __construct()
    {
        parent::__construct('auth');
    }

    public function listar()
    {
        if(parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);

        $produtos = Produto::all();

        $produtos = $this->formatInputListagem($produtos);

        return view('adm.produtos.listagem')
            ->with('produtos', $produtos)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function salvar(ProdutoRequest $request)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            return parent::salvarDados($request);

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar permissão. Tente mais tarde.'));
        }
    }

    public function atualizar(ProdutoRequest $request, $id)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            return parent::atualizarDados($request, $id);

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array($e->getMessage()));
        }
    }

    protected function formatOutput($request)
    {
        $request['preco'] = str_replace('.', '', $request['preco']);
        $request['preco'] = str_replace(',', '.', $request['preco']);

        return $request;
    }

    protected function formatInput($request)
    {
        if($request->preco != '') {
            $request->preco = number_format($request->preco, 2, ',', '.');
        }

        return $request;
    }

    protected function formatInputListagem($request)
    {
        foreach ($request as $produto) {
            $produto['preco'] = "R$ ". number_format($produto['preco'], 2, ',', '.');
        }

        return $request;
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
