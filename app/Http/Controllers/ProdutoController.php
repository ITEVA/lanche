<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
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
        return parent::formatOutput($request);
    }

    protected function formatInput($request)
    {
        return parent::formatInput($request);
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
