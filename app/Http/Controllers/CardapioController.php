<?php

namespace App\Http\Controllers;

use App\Cardapio;
use App\Http\Requests\CardapioRequest;
use App\Produto;
use App\ProdutoCardapio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Types\Array_;

class CardapioController extends AbstractCrudController
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

        $cardapios = Cardapio::all();

        foreach ($cardapios as $cardapio) {
            $cardapio['diaSemana'] = $this->diaSemana($cardapio->data);
            $cardapio['produtos'] = ProdutoCardapio::where(['id_cardapio' => $cardapio->id, 'id_empregador' => Auth::user()->id_empregador])->get();

            foreach ($cardapio['produtos'] as $produto) {
                $produto['produto'] = Produto::where(['id' => $produto->id_produto, 'id_empregador' => Auth::user()->id_empregador])->get();
            }
        }

        return view('adm.cardapios.listagem')
            ->with('cardapios', $cardapios)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function novo(){
        $produtos = Produto::all();
        return parent::novo()
            ->with('produtos', $produtos);
    }

    public function editar($id){
        $produtos = Produto::all();
        $produtosAtuais = ProdutoCardapio::where(['id_cardapio'=>$id])->get();

        return parent::editar($id)
            ->with('produtos', $produtos)
            ->with('produtosAtuais', $produtosAtuais);
    }

    public function salvar(CardapioRequest $request)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            $c = array(
                "data" => $request['data'],
                "descricao" => $request['descricao'],
                "id_empregador" => $request['id_empregador'],
                "hora_inicio" => $request['hora_inicio'],
                "hora_final" => $request['hora_final'],
                "turno" => $request['turno']
            );

            $c = $this->formatOutput($c);

            $cardapio = Cardapio::create($c);

            $this->salvarProdutosCardapio($request, $cardapio->id);

            return redirect()
                ->action('CardapioController@listar');

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar cardapio. Tente mais tarde.'));
        }
    }

    public function atualizar(CardapioRequest $request, $id)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            $this->removerProdutosCardapio($id);
            $this->salvarProdutosCardapio($request, $id);

            unset($request['produtos']);
            unset($request['ids']);
            unset($request['nome']);
            unset($request['quantidade']);

            return parent::atualizarDados($request, $id);

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array($e->getMessage()));
        }
    }

    public function editarLote(Request $request)
    {
        $produtos = Produto::all();

        return parent::editarLote($request)
            ->with('produtos', $produtos);
    }

    public function atualizarLote(Request $request)
    {
        $ids = explode('-', $request['ids']);
        foreach ($ids as $id){
            $this->removerProdutosCardapio($id);
            $this->salvarProdutosCardapio($request['produtos'], $id);
        }
        unset($request['produtos']);

        return parent::atualizarLote($request);
    }

    public function salvarProdutosCardapio($request, $id)
    {
        $idsProdutos = array();
        $nomesProdutos = array();
        $quantidadesProdutos = array();

        $i = 0;
        foreach ($request->ids as $idProduto) {
            $idsProdutos[$i] = $idProduto;
            $i++;
        }

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

        for ($i = 0; $i < count($nomesProdutos); $i++) {
            $produto = array(
                "nome" => $nomesProdutos[$i],
                "quantidade" => str_replace(",", ".", $quantidadesProdutos[$i]),
                "id_cardapio" => $id,
                "id_produto" => $idsProdutos[$i],
                "id_empregador" => Auth::user()->id_empregador
            );
            ProdutoCardapio::create($produto);
        }
    }

    public function removerProdutosCardapio($id)
    {
        $produtos = ProdutoCardapio::where(['id_cardapio'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();
        foreach ($produtos as $produto) {
            $produto->delete();
        }
    }

    private function diaSemana($data)
    {
        $diaSemana = date("N", strtotime($data));
        if($diaSemana == 1)
            return "Segunda-Feira";
        else if($diaSemana == 2)
            return "Terça-Feira";
        else if($diaSemana == 3)
            return "Quarta-Feira";
        else if($diaSemana == 4)
            return "Quinta-Feira";
        else if($diaSemana == 5)
            return "Sexta-Feira";
        else if($diaSemana == 6)
            return "Sábado";
        else
            return "Domingo";
    }

    /**
     * Retorna a data com o formato a ser inserido no banco
     * @param $dataBr
     * @return string
     */
    private function formatarDataEn($dataBr)
    {
        $date = implode("-",array_reverse(explode("/", $dataBr)));
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Retorna a data com o formato a ser mostrado ao usuario
     * @param $dataEn
     * @return string
     */
    private function formatarDataBr($dataEn)
    {
        $date = implode("/",array_reverse(explode("-", $dataEn)));
        return $date;
    }

    protected function formatOutput($request)
    {
        $request['data'] = $this->formatarDataEn($request['data']);
        return $request;
    }

    protected function formatInput($request)
    {
       $request->data = $this->formatarDataBr($request->data);
        return $request;
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
