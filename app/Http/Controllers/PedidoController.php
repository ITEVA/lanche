<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Cardapio;
use App\Pedido;
use App\Produto;
use App\ProdutoCardapio;
use App\ProdutoPedido;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PedidoController extends AbstractCrudController
{
    private $filtro = [];

    public function __construct()
    {
        parent::__construct('auth');
    }

    public function novo(){
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');

        $cardapio = Cardapio::where(['data'=>$date])->get();
        $produtosDia = ProdutoCardapio::where(['id_cardapio'=>$cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia){
            $produto = Produto::where(['id'=>$produtoDia->id_produto])->get();
            $produtos[$i] = $produto;
            $i++;
        }

        return parent::novo()
            ->with('produtos', $produtos);
    }

    public function editar($id){
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');

        $cardapio = Cardapio::where(['data'=>$date])->get();
        $produtosDia = ProdutoCardapio::where(['id_cardapio'=>$cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia){
            $produto = Produto::where(['id'=>$produtoDia->id_produto])->get();
            $produtos[$i] = $produto;
            $i++;
        }

        $produtosPedido = ProdutoPedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_pedido' => $id])->get();

        return parent::editar($id)
            ->with('produtos', $produtos)
            ->with('produtosPedido', $produtosPedido);
    }

    public function salvar(PedidoRequest $request)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            $this->salvarPedido($request);

            return redirect()
                ->action('PedidoController@listar');

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar permissão. Tente mais tarde.'));
        }
    }

    public function atualizar(PedidoRequest $request, $id)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            $this->removerProdutosPedido($id);
            $this->salvarPedido($request, $id);

            return redirect()
                ->action('PedidoController@listar');

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array($e->getMessage()));
        }
    }

    private function salvarPedido($request, $id = null)
    {
        $nomesProdutos = array();
        $quantidadesProdutos = array();
        $precosProdutos = array();
        $precosTotaisProdutos = array();

        $i = 0;
        foreach ($request->nome as $nomeProduto) {
            $nomesProdutos[$i] = $nomeProduto;
            $i++;
        }

        $i = 0;
        foreach ($request->quantidade as $quantidadeProduto) {
            $quantidadesProdutos[$i] = $quantidadeProduto;
            $i++;
        }

        $i = 0;
        foreach ($request->precoUnitario as $precoProduto) {
            $precosProdutos[$i] = $precoProduto;
            $i++;
        }

        $i = 0;
        $precoTotal = 0;
        for ($i = 0; $i < count($nomesProdutos); $i++) {
            $precosTotaisProdutos[$i] = ($quantidadesProdutos[$i] * $precosProdutos[$i]);
            $precoTotal = $precoTotal + $precosTotaisProdutos[$i];
        }

        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');

        $dadosPedido = array(
            "data" => $date,
            "preco" => $precoTotal,
            "observacao" => $request->observacao,
            "id_usuario" => Auth::user()->id,
            "id_empregador" => Auth::user()->id_empregador
        );

        if($id != null) {
            $pedido = Pedido::find($id);
            $pedido->fill($dadosPedido);
            $pedido->save();
        }
        else
        $pedido = Pedido::create($dadosPedido);

        for ($i = 0; $i < count($nomesProdutos); $i++) {
            $produto = array(
                    "nome" => $nomesProdutos[$i],
                    "quantidade" => $quantidadesProdutos[$i],
                    "preco_unitario" => $precosProdutos[$i],
                    "preco_total" => $precosTotaisProdutos[$i],
                    "id_pedido" => $pedido->id,
                    "id_empregador" => Auth::user()->id_empregador
            );

            ProdutoPedido::create($produto);
        }
    }

    private function removerProdutosPedido($id)
    {
        $produtos = ProdutoPedido::where(['id_pedido'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();
        foreach ($produtos as $produto) {
            $produto->delete();
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
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');
        return ['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => Auth::user()->id , 'data' => $date];
    }
}
