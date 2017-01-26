<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissaoRequest;
use App\Permissao;
use App\PermissaoClasse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PermissaoController extends AbstractCrudController
{
    private $filtro = [];

    public function __construct()
    {
        parent::__construct('auth');
    }

    public function editar($id)
    {
        $permissoes = PermissaoClasse::where(['id_permissao'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();

        $permissoesAtuais = array();

        foreach ($permissoes as $permissao) {
            $permissoesAtuais[$permissao->classe] = 1;
        }

        return parent::editar($id)
            ->with('permissoesAtuais', $permissoesAtuais);
    }

    public function salvar(PermissaoRequest $request)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        $dadosClasses['inicio'] = $request['inicio'];
        $dadosClasses['user'] = $request['user'];
        $dadosClasses['permissao'] = $request['permissao'];
        $dadosClasses['produto'] = $request['produto'];
        $dadosClasses['cardapio'] = $request['cardapio'];
        $dadosClasses['perfil'] = $request['perfil'];
        $dadosClasses['pedido'] = $request['pedido'];
        $dadosClasses['corrigirPedido'] = $request['corrigirPedido'];
        $dadosClasses['relatorio'] = $request['relatorio'];

        unset($request['inicio']);
        unset($request['user']);
        unset($request['permissao']);
        unset($request['produto']);
        unset($request['cardapio']);
        unset($request['perfil']);
        unset($request['pedido']);
        unset($request['corrigirPedido']);
        unset($request['relatorio']);

        if(isset($request['salvar'])) unset($request['salvar']);

        try {
            $dados = $this->formatOutput($request->except('_token'));
            $permicao = Permissao::create($dados);

            $this->salvarClassesPermissoes($dadosClasses, $permicao->id);

            return redirect()
                ->action('PermissaoController@listar');

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar permissão. Tente mais tarde.'));
        }
    }

    public function atualizar(PermissaoRequest $request, $id)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            $this->removerClassesPermissoes($id);
            $dados = $this->salvarClassesPermissoes($request, $id);

            return parent::atualizarDados($dados, $id);

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array($e->getMessage()));
        }
    }

    public function salvarClassesPermissoes($object, $id)
    {
        if($object['inicio']) {
            $permissao = array(
                'classe' => 'inicio',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['user']) {
            $user = array(
                'classe' => 'user',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($user);
        }

        if($object['permissao']) {
            $permissao = array(
                'classe' => 'permissao',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['produto']) {
            $permissao = array(
                'classe' => 'produto',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['cardapio']) {
            $permissao = array(
                'classe' => 'cardapio',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['perfil']) {
            $permissao = array(
                'classe' => 'perfil',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['pedido']) {
            $permissao = array(
                'classe' => 'pedido',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['corrigirPedido']) {
            $permissao = array(
                'classe' => 'corrigirPedido',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['relatorio']) {
            $permissao = array(
                'classe' => 'relatorio',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        unset($object['inicio']);
        unset($object['user']);
        unset($object['permissao']);
        unset($object['produto']);
        unset($object['cardapio']);
        unset($object['perfil']);
        unset($object['pedido']);
        unset($object['corrigirPedido']);
        unset($object['relatorio']);

        return $object;
    }

    public function removerClassesPermissoes($id)
    {
        $permissoes = PermissaoClasse::where(['id_permissao'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();
        foreach ($permissoes as $permissao) {
            $permissao->delete();
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
