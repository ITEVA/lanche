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

    public function listar()
    {
        if(parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);

        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');
        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => Auth::user()->id , 'data' => $date])->get();
        $pedidos = $this->formatInputListagem($pedidos);

        foreach ($pedidos as $pedido){
            $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $pedido->id_cardapio])->get();
            $pedido['turno'] = $cardapio[0]['turno'] ? "Manhã" : "Tarde";
        }

        return view('adm.pedidos.listagem')
            ->with('pedidos', $pedidos)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function novo(){
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');
        $hora = date('H:i');

        if($hora >= '00:00' && $hora <= '11:59')
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '1'])->get();
        else
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '0'])->get();

        $produtosDia = ProdutoCardapio::where(['id_cardapio'=>$cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia){
            $produto = Produto::where(['id'=>$produtoDia->id_produto])->get();
            $produtos[$i] = $produto;
            $i++;
        }

        $pedido = Pedido::where(['data' => $date, 'id_usuario' => Auth::user()->id, 'id_empregador' => Auth::user()->id_empregador, 'id_cardapio' => $cardapio[0]->id])->get();

        if(count($pedido) != 0) {
            return redirect('pedidos');
        }
        else{
            return parent::novo()
                ->with('produtos', $produtos)
                ->with('cardapio', $cardapio);
        }
    }

    public function editar($id){
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');
        $hora = date('H:i');

        if($hora >= '00:00' && $hora <= '11:59')
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '1'])->get();
        else
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '0'])->get();

        $produtosDia = ProdutoCardapio::where(['id_cardapio'=>$cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia){
            $produto = Produto::where(['id'=>$produtoDia->id_produto])->get();
            $produtos[$i] = $produto;
            $i++;
        }

        $produtosPedido = ProdutoPedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_pedido' => $id])->get();

        $pedido = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $id])->get();

        //Checando se o tempo já acabou
        $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $pedido[0]['id_cardapio']])->get();

        if($hora < $cardapio[0]->hora_inicio || $hora > $cardapio[0]->hora_final) {
            return redirect('pedidos');
        }
        else {
            return parent::editar($id)
                ->with('produtos', $produtos)
                ->with('produtosPedido', $produtosPedido)
                ->with('cardapio', $cardapio);
        }
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
            "id_cardapio" => $request->cardapio,
            "id_empregador" => Auth::user()->id_empregador,
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
                "quantidade" => str_replace(",", ".", $quantidadesProdutos[$i]),
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

    protected function formatInputListagem($request)
    {
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');
        $hora = date('H:i');

        if($hora >= '00:00' && $hora <= '11:59')
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '1'])->get();
        else
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '0'])->get();

        //Busca um pedido se já tiver sido feito
        $request[0]['pedido'] = Pedido::where(['data' => $date, 'id_usuario' => Auth::user()->id, 'id_empregador' => Auth::user()->id_empregador, 'id_cardapio' => $cardapio[0]->id])->get();

        foreach ($request as $produto) {
            $produto['preco'] = str_replace('.', ',', $produto['preco']);

            $precoQ = explode(",", $produto['preco']);

            if(!isset($precoQ[1]))
                $produto['preco'] = "R$ ".$precoQ[0].",00";
            else
                $produto['preco'] = "R$ ".($precoQ[1] < 10 ? $precoQ[0].",".$precoQ[1]."0" : $precoQ[0].",".$precoQ[1]);

            //Checando se o tempo já acabou
            $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $produto['id_cardapio']])->get();

            if($hora < $cardapio[0]->hora_inicio || $hora > $cardapio[0]->hora_final) {
                $produto['tempoEsgotado'] = true;
            }
        }

        return $request;
    }

    protected function getFilter()
    {
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');
        return ['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => Auth::user()->id , 'data' => $date];
    }
}
