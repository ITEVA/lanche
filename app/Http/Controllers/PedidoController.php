<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Cardapio;
Use App\User;
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
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);

        $date = $this->dataAtual();
        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => Auth::user()->id, 'data' => $date])->get();
        $pedidos = $this->formatInputListagem($pedidos);

        foreach ($pedidos[1] as $pedido) {
            $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $pedido->id_cardapio])->get();

            $pedido['turno'] = $cardapio[0]['turno'] ? "Manhã" : "Tarde";
            $pedido['diaSemana'] = $this->diaSemana($pedido->data);
            $pedido['produtos'] = ProdutoPedido::where(['id_pedido' => $pedido->id, 'id_empregador' => Auth::user()->id_empregador])->get();
        }

        return view('adm.pedidos.listagem')
            ->with('pedidos', $pedidos)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function listarCorrigir()
    {
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
        if(!array_key_exists("corrigirPedido", $itensPermitidos))
            return redirect('error404');

        $intervalo = $this->intevaloMes();

        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$intervalo['ini'], $intervalo['fim']])->get();
        $pedidos = $this->formatInputListagem($pedidos);

        $intervalo['ini']  = date('d/m/Y', strtotime($intervalo['ini']));
        $intervalo['fim']  = date('d/m/Y', strtotime($intervalo['fim']));

        $pedidos = $this->formatInputListagemCorrigir($pedidos);

        return view('adm.pedidos.listagemCorrigir')
            ->with('pedidos', $pedidos)
            ->with('intervalo', $intervalo)
            ->with('itensPermitidos', $itensPermitidos);
    }

    protected function listarFiltroCorrigir(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $intervalo = array(
            "ini" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataIni))),
            "fim" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataFim)))
        );

        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$intervalo['ini'], $intervalo['fim']])->get();
        $pedidos = $this->formatInputListagem($pedidos);

        $intervalo['ini']  = date('d/m/Y', strtotime($intervalo['ini']));
        $intervalo['fim']  = date('d/m/Y', strtotime($intervalo['fim']));

        $pedidos = $this->formatInputListagemCorrigir($pedidos);

        return view('adm.pedidos.listagemCorrigir')
            ->with('pedidos', $pedidos)
            ->with('intervalo', $intervalo)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function novo()
    {
        $cardapio = $this->getCardapioDia();
        if (!$this->checaExistsCardapio($cardapio))
            return redirect('pedidos');

        $produtosDia = ProdutoCardapio::where(['id_cardapio' => $cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia) {
            $produto = Produto::find($produtoDia->id_produto);
            $produtos[$i] = $produto;
            $i++;
        }

        $produtos = $this->insertionSort($produtos);

        if ($this->checaExistsPedido($cardapio[0]['id']) != 0 || $this->checaTempoCardapio($cardapio[0]['id'])) {
            return redirect('pedidos');
        }
        else {
            return parent::novo()
                ->with('produtos', $produtos)
                ->with('cardapio', $cardapio)
                ->with('sanduiche', '0');
        }
    }

    public function novoCorrigir()
    {
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
        if(!array_key_exists('corrigirPedido', $itensPermitidos))
            return redirect('error404');

        $intervalo = $this->intevaloMes();

        $cardapios = Cardapio::where(['id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$intervalo['ini'], $intervalo['fim']])->orderBy('data', 'asc')->orderBy('turno', 'desc')->get();

        $intervalo['ini']  = date('d/m/Y', strtotime($intervalo['ini']));
        $intervalo['fim']  = date('d/m/Y', strtotime($intervalo['fim']));

        return view('adm.pedidos.formularioCorrigir')
            ->with('actionFiltro', 'pedidos/corrigir/novo/1')
            ->with('cardapios', $cardapios)
            ->with('intervalo', $intervalo)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function novoFiltroCorrigir(Request $request)
    {
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
        if(!array_key_exists('corrigirPedido', $itensPermitidos))
            return redirect('error404');

        $intervalo = array(
            "ini" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataIni))),
            "fim" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataFim)))
        );

        $cardapios = Cardapio::where(['id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$intervalo['ini'], $intervalo['fim']])->orderBy('data', 'asc')->orderBy('turno', 'desc')->get();

        $intervalo['ini']  = date('d/m/Y', strtotime($intervalo['ini']));
        $intervalo['fim']  = date('d/m/Y', strtotime($intervalo['fim']));

        return view('adm.pedidos.formularioCorrigir')
            ->with('actionFiltro', 'pedidos/corrigir/novo/1')
            ->with('cardapios', $cardapios)
            ->with('intervalo', $intervalo)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function novoProdutosCorrigir(Request $request)
    {
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
        if(!array_key_exists('corrigirPedido', $itensPermitidos))
            return redirect('error404');

        $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $request->cardapio])->get();

        if (!$this->checaExistsCardapio($cardapio))
            return redirect('pedidos/corrigir');

        $produtosDia = ProdutoCardapio::where(['id_cardapio' => $cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia) {
            $produto = Produto::find($produtoDia->id_produto);
            $produtos[$i] = $produto;
            $i++;
        }

        $produtos = $this->insertionSort($produtos);

        $dataIniFim = $this->dataIniFim();

        $cardapios = Cardapio::where(['id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$dataIniFim['ini'], $dataIniFim['fim']])->get();

        $pedido = (object)[
            'preco' => '',
            'observacao' => '',
            'motivo_correcao' => '',
            'data' => '',
            'id_produto' => '',
            'id_usuario' => ''
        ];

        $usuarios = User::where(['id_empregador' => Auth::user()->id_empregador])->orderBy('apelido', 'asc')->get();

        return view('adm.pedidos.formularioCorrigir')
            ->with('action', 'pedidos/corrigir/salvar')
            ->with('cardapio', $cardapio)
            ->with('cardapios', $cardapios)
            ->with('produtos', $produtos)
            ->with('pedido', $pedido)
            ->with('usuarios', $usuarios)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function editar($id)
    {
        $cardapio = $this->getCardapioDia();
        if (!$this->checaExistsCardapio($cardapio))
            return redirect('pedidos');

        $produtosDia = ProdutoCardapio::where(['id_cardapio' => $cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia) {
            $produto = Produto::find($produtoDia->id_produto);
            $produtos[$i] = $produto;
            $i++;
        }

        $produtos = $this->insertionSort($produtos);

        $produtosPedido = ProdutoPedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_pedido' => $id])->get();

        $pedido = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $id])->get();

        if (count($pedido) > 0)
            if(Auth::user()->id != $pedido[0]->id_usuario) return redirect('error404');

        $tipoPaes = Produto::where(['id_empregador' => Auth::user()->id_empregador])->whereIn('nome', ['Pão carioca', 'Pão de forma', 'Pão integral', 'Pão sovado'])->get();

        $tiposRecheio = Produto::where(['id_empregador' => Auth::user()->id_empregador])->whereIn('nome', ['Margarina', 'Requeijão'])->get();

        $pao  = 0;
        $sanduiche  = 0;
        foreach ($produtosPedido as $produtoPedido) {
            $nomeQ = explode(" ", $produtoPedido->nome);
            if ($nomeQ[0] === "Sand.") {
                $produtoPedido['sanduiche'] = 1;
                $sanduiche = 1;
            }
            if ($nomeQ[0] === "Pão") {
                $produtoPedido['pao'] = 1;
                $pao = 1;
            }

            $produtoPedido['valorFormado'] = ($produtoPedido->preco_total) / ($produtoPedido->quantidade);
        }

        if ($this->checaTempoCardapio($pedido[0]['id_cardapio'])) {
            return redirect('pedidos');
        } else {
            return parent::editar($id)
                ->with('produtos', $produtos)
                ->with('produtosPedido', $produtosPedido)
                ->with('cardapio', $cardapio)
                ->with('tipoPaes', $tipoPaes)
                ->with('tiposRecheio', $tiposRecheio)
                ->with('sanduiche', $sanduiche)
                ->with('pao', $pao);
        }
    }

    public function editarCorrigir($id)
    {
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
        if(!array_key_exists('corrigirPedido', $itensPermitidos))
            return redirect('error404');

        $pedido = Pedido::find($id);

        $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $pedido->id_cardapio])->get();

        $produtosDia = ProdutoCardapio::where(['id_cardapio' => $cardapio[0]->id])->get();

        $produtos = array();

        $i = 0;
        foreach ($produtosDia as $produtoDia) {
            $produto = Produto::find($produtoDia->id_produto);
            $produtos[$i] = $produto;
            $i++;
        }

        $produtos = $this->insertionSort($produtos);

        $produtosPedido = ProdutoPedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_pedido' => $id])->get();

        return view('adm.pedidos.formularioCorrigir')
            ->with('action', 'pedidos/corrigir/atualizar/'.$id)
            ->with('produtos', $produtos)
            ->with('produtosPedido', $produtosPedido)
            ->with('cardapio', $cardapio)
            ->with('pedido', $pedido)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function salvar(PedidoRequest $request)
    {
        $cardapio = $this->getCardapioDia();
        if (!$this->checaExistsCardapio($cardapio) || $this->checaExistsPedido($cardapio[0]['id']) || $this->checaTempoCardapio($cardapio[0]['id']))
            return redirect('pedidos');

        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            if (count($request->nome) > 0) {
                $this->salvarPedido($request);

                return redirect()
                    ->action('PedidoController@listar');
            }

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar pedido. Tente mais tarde.'));
        }
    }

    public function salvarCorrigir(PedidoRequest $request)
    {
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
        if(!array_key_exists('corrigirPedido', $itensPermitidos))
            return redirect('error404');

        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            if (count($request->nome) > 0) {
                $this->salvarPedidoCorrigir($request);

                return redirect()
                    ->action('PedidoController@listarCorrigir');
            }
        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar pedido. Tente mais tarde.'));
        }
    }

    public function atualizar(PedidoRequest $request, $id)
    {
        $cardapio = $this->getCardapioDia();
        if (!$this->checaExistsCardapio($cardapio) || $this->checaTempoCardapio($cardapio[0]['id']))
            return redirect('pedidos');

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

    public function atualizarCorrigir(PedidoRequest $request, $id)
    {
        if (parent::checkPermissao()) return redirect('error404');
        $itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
        if(!array_key_exists('corrigirPedido', $itensPermitidos))
            return redirect('error404');

        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            $this->removerProdutosPedido($id);
            $this->salvarPedidoCorrigir($request, $id);

            return redirect()
                ->action('PedidoController@listarCorrigir');

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
        $nomesProdutosFormados = array();
        $quantidadesProdutos = array();
        $precosProdutos = array();
        $precosFormadosProdutos = array();
        $precosTotaisProdutos = array();
        $tiposPao = array();
        $tiposChapado = array();
        $tiposRecheios = array();

        $i = 0;
        foreach ($request->nome as $nomeProduto) {
            $nomesProdutos[$i] = $nomeProduto;
            $i++;
        }

        $i = 0;
        foreach ($request->nomeFormado as $nomeProdutoFormado) {
            $nomesProdutosFormados[$i] = $nomeProdutoFormado;
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
        foreach ($request->precoTotal as $precoFormadoProduto) {
            $precosFormadosProdutos[$i] = $precoFormadoProduto;
            $i++;
        }

        $i = 0;
        foreach ($request->tipoPao as $tipoPao) {
            $tiposPao[$i] = $tipoPao == "undefined" ? "" : $tipoPao;
            $i++;
        }

        $i = 0;
        foreach ($request->tipoChapado as $tipoChapado) {
            $tiposChapado[$i] = $tipoChapado == "undefined" ? "" : $tipoChapado;
            $i++;
        }

        $i = 0;
        foreach ($request->tipoRecheio as $tipoRecheio) {
            $tiposRecheios[$i] = $tipoRecheio == "undefined" ? "" : $tipoRecheio;
            $i++;
        }

        $i = 0;
        $precoTotal = 0;
        for ($i = 0; $i < count($nomesProdutos); $i++) {
            $precosTotaisProdutos[$i] = $precosFormadosProdutos[$i];
            $precoTotal = $precoTotal + $precosTotaisProdutos[$i];
        }

        $date = $this->dataAtual();

        $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $request->cardapio])->get();

        $dadosPedido = array(
            "data" => $cardapio[0]->data,
            "preco" => $precoTotal,
            "observacao" => $request->observacao,
            "turno" => $cardapio[0]->turno,
            "id_usuario" => Auth::user()->id,
            "id_cardapio" => $request->cardapio,
            "id_empregador" => Auth::user()->id_empregador,
        );

        if ($id != null) {
            $pedido = Pedido::find($id);
            $pedido->fill($dadosPedido);
            $pedido->save();
        }
        else
            $pedido = Pedido::create($dadosPedido);

        for ($i = 0; $i < count($nomesProdutos); $i++) {
            $produto = array(
                "nome" => $nomesProdutos[$i],
                "nome_formado" => $nomesProdutosFormados[$i],
                "quantidade" => str_replace(",", ".", $quantidadesProdutos[$i]),
                "tipo_pao" => $tiposPao[$i],
                "chapado" => $tiposChapado[$i],
                "tipo_recheio" => $tiposRecheios[$i],
                "data" => $date,
                "turno" => $cardapio[0]->turno,
                "preco_unitario" => $precosProdutos[$i],
                "preco_total" => $precosFormadosProdutos[$i],
                "id_pedido" => $pedido->id,
                "id_empregador" => Auth::user()->id_empregador
            );

            ProdutoPedido::create($produto);
        }
    }

    private function salvarPedidoCorrigir($request, $id = null)
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

        $date = $this->dataAtual();

        $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $request->cardapio])->get();

        date_default_timezone_set('America/Fortaleza');

        $dadosPedido = array(
            "data" => $cardapio[0]->data,
            "preco" => $precoTotal,
            "observacao" => $request->observacao,
            "turno" => $cardapio[0]->turno,
            "corrigido" => '1',
            "motivo_correcao" => $request->motivo_correcao,
            "data_correcao" => date("Y/m/d H:i"),
            "responsavel_correcao" => Auth::user()->apelido,
            "id_usuario" => $request->usuario,
            "id_cardapio" => $request->cardapio,
            "id_empregador" => Auth::user()->id_empregador,
        );

        if ($id != null) {
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
                "data" => $cardapio[0]->data,
                "turno" => $cardapio[0]->turno,
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
        $produtos = ProdutoPedido::where(['id_pedido' => $id, 'id_empregador' => Auth::user()->id_empregador])->get();
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
        $cardapio = $this->getCardapioDia();

        $produtos = array();

        if ($this->checaExistsCardapio($cardapio)) {
            if ($this->checaTempoCardapio($cardapio[0]['id'])) {
                $produtos[0]['popover'] = true;
                $produtos[0]['msg'] = "Espere o horário para lançamento de pedidos";
            }
            else {
                $produtos[0]['popover'] = $this->checaExistsPedido($cardapio[0]['id']);
                $produtos[0]['msg'] = "Já existe um pedido para este turno";
            }
        }
        else {
            $produtos[0]['popover'] = true;
            $produtos[0]['msg'] = "Não existe um cardápio para este turno";
        }

        foreach ($request as $pedido) {
            $pedido['preco'] = "R$ " . number_format($pedido['preco'], 2, ',', '.');

            $pedido['tempoEsgotado'] = $this->checaTempoCardapio($pedido['id_cardapio']);
        }

        $produtos[1] = $request;

        return $produtos;
    }

    protected function formatInputListagemCorrigir($pedidos)
    {
        foreach ($pedidos[1] as $pedido) {
            $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $pedido->id_cardapio])->get();

            $pedido['turno'] = $cardapio[0]['turno'] ? "Manhã" : "Tarde";
            $pedido['diaSemana'] = $this->diaSemana($pedido->data);
            $pedido['produtos'] = ProdutoPedido::where(['id_pedido' => $pedido->id, 'id_empregador' => Auth::user()->id_empregador])->get();
            $pedido['nomeUsuario'] = User::where(['id' => $pedido->id_usuario, 'id_empregador' => Auth::user()->id_empregador])->get();

            if ($pedido->data_correcao != '')
                $pedido['dataAlteracao'] = date("d/m/Y H:i", strtotime($pedido->data_correcao));
        }

        return $pedidos;
    }

    private function intevaloMes()
    {
        date_default_timezone_set('America/Fortaleza');
        $date = $this->dataAtual();
        $dateQ = explode("-", $date);
        $dateI = $dateQ[0]."-".$dateQ[1]. "-01";
        $dateF = $dateQ[0]."-".$dateQ[1];
        $intervalo = array(
            "ini" => $dateI,
            "fim" => ""
        );

        if($dateQ[1] == 1 || $dateQ[1] == 3 || $dateQ[1] == 5 || $dateQ[1] == 7 || $dateQ[1] == 8 || $dateQ[1] == 10 || $dateQ[1] == 12)
            $dateF = $dateQ[0]."-".$dateQ[1]."-31";
        else if($dateQ[1] == 4 || $dateQ[1] == 6 || $dateQ[1] == 9 || $dateQ[1] == 11)
            $dateF = $dateQ[0]."-".$dateQ[1]."-30";
        else{
            $bissexto = false;
            if ($dateQ[0] % 400 == 0)
                $bissexto = true;
            else if (($dateQ[0] % 4 == 0) && ($dateQ[0] % 100 != 0))
                $bissexto = true;
            else
                $bissexto = false;

            if($bissexto)
                $dateF = $dateQ[0]."-".$dateQ[1]."-29";
            else
                $dateF = $dateQ[0]."-".$dateQ[1]."-28";

        }

        $intervalo['fim'] = $dateF;

        return $intervalo;
    }

    private function dataIniFim()
    {
        date_default_timezone_set('America/Fortaleza');
        $date = date('Y-m-d');
        $dateQ = explode("-", $date);
        $dateI = $dateQ[0]."-".$dateQ[1]. "-01";
        $dateF = $dateQ[0]."-".$dateQ[1];

        if($dateQ[1] == 1 || $dateQ[1] == 3 || $dateQ[1] == 5 || $dateQ[1] == 7 || $dateQ[1] == 8 || $dateQ[1] == 10 || $dateQ[1] == 12)
            $dateF = $dateQ[0]."-".$dateQ[1]."-31";
        else if($dateQ[1] == 4 || $dateQ[1] == 6 || $dateQ[1] == 9 || $dateQ[1] == 11)
            $dateF = $dateQ[0]."-".$dateQ[1]."-30";
        else{
            $bissexto = false;
            if ($dateQ[0] % 400 == 0)
                $bissexto = true;
            else if (($dateQ[0] % 4 == 0) && ($dateQ[0] % 100 != 0))
                $bissexto = true;
            else
                $bissexto = false;

            if($bissexto)
                $dateF = $dateQ[0]."-".$dateQ[1]."-29";
            else
                $dateF = $dateQ[0]."-".$dateQ[1]."-28";
        }

        $data = array(
                "ini" => $dateI,
                "fim" => $dateF
        );

        return $data;
    }

    private function diaSemana($data)
    {
        $diaSemana = date("N", strtotime($data));
        if ($diaSemana == 1)
            return "Segunda-Feira";
        else if ($diaSemana == 2)
            return "Terça-Feira";
        else if ($diaSemana == 3)
            return "Quarta-Feira";
        else if ($diaSemana == 4)
            return "Quinta-Feira";
        else if ($diaSemana == 5)
            return "Sexta-Feira";
        else if ($diaSemana == 6)
            return "Sábado";
        else
            return "Domingo";
    }

    private function dataAtual()
    {
        date_default_timezone_set('America/Fortaleza');
        return $date = date('Y-m-d');
    }

    private function getCardapioDia()
    {
        $date = $this->dataAtual();
        date_default_timezone_set('America/Fortaleza');
        $hora = date('H:i');
        $cardapio = '';

        if ($hora >= '00:00' && $hora <= '11:59')
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '1'])->get();
        else
            $cardapio = Cardapio::where(['data' => $date, 'turno' => '0'])->get();

        return $cardapio;
    }

    private function checaTempoCardapio($id)
    {
        $cardapio = Cardapio::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $id])->get();

        date_default_timezone_set('America/Fortaleza');
        $hora = date('H:i');
        if ($hora < $cardapio[0]->hora_inicio || $hora > $cardapio[0]->hora_final)
            return true;
        else
            return false;
    }

    private function checaExistsPedido($id)
    {
        $date = $this->dataAtual();
        $pedidos = Pedido::where(['data' => $date, 'id_usuario' => Auth::user()->id, 'id_empregador' => Auth::user()->id_empregador, 'id_cardapio' => $id])->get();
        return count($pedidos) != 0 ? true : false;
    }

    private function checaExistsCardapio($cardapio)
    {
        if (count($cardapio) != 0) {
            return true;
        } else
            return false;
    }

    protected function getFilter()
    {
        $date = $this->dataAtual();
        return ['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => Auth::user()->id, 'data' => $date];
    }

    public function insertionSort(array $array)
    {
        $length = count($array);
        $i = 0; $j = 0;
        for ($i = 1; $i < $length; $i++) {
            $element = $array[$i];
            $j = $i;
            while ($j > 0 && $array[$j - 1]->nome > $element->nome) {
                //move value to right and key to previous smaller index
                $array[$j] = $array[$j - 1];
                $j = $j - 1;
            }
            //put the element at index $j
            $array[$j] = $element;
        }
        return $array;
    }
}