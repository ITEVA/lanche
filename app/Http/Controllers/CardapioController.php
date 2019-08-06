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

        $cardapios = Cardapio::whereBetween('data', [date('Y').'-01-01', date('Y').'-12-31'])->get();

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
        $produtos = Produto::where(['status' => 1, 'id_empregador' => Auth::user()->id_empregador])->get();
        return parent::novo()
            ->with('produtos', $produtos);
    }

    public function novoLote(){
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $cardapio = Cardapio::getEmpty();
        $produtos = Produto::where(['id_empregador' => Auth::user()->id_empregador])->get();

        return view('adm.cardapios.formularioLote')
            ->with('cardapio', $this->formatInput($cardapio))
            ->with('action', 'cardapios/salvarLote')
            ->with('produtos', $produtos)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function editar($id){
        $produtos = Produto::where(['status' => 1, 'id_empregador' => Auth::user()->id_empregador])->get();
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

            $cardapios = Cardapio::where(['data' => $c['data'], 'turno' => $c['turno']])->get();

            if (count($cardapios) > 0) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(array('Já existe um cardápio para o dia '. $this->formatarDataBr($c['data']) .' edite ou exclua se quiser um novo!'));
            }

            else {
                $cardapio = Cardapio::create($c);

                $this->salvarProdutosCardapio($request, $cardapio->id);

                return redirect()
                    ->action('CardapioController@listar');
            }


        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar cardapio. Tente mais tarde.'));
        }
    }

    public function salvarLote(CardapioRequest $request)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        $dataInicio = $this->formatarDataEn($request->dataIni);
        $dataFim = $this->formatarDataEn($request->dataFim);

        $dataCriada = $dataInicio;

        try {
            $c = array(
                "data" => $dataInicio,
                "descricao" => $request['descricao'],
                "id_empregador" => $request['id_empregador'],
                "hora_inicio" => $request['hora_inicio'],
                "hora_final" => $request['hora_final'],
                "turno" => $request['turno']
            );

            $c = $this->formatOutput($c);
            $cardapios = Cardapio::where(['data' => $c['data'], 'turno' => $c['turno']])->get();

            $erros = "";
            if (count($cardapios) > 0) {
                $erros = $erros . $this->formatarDataBr($c['data']). ", ";
            }
            else {
                $cardapio = Cardapio::create($c);
                $this->salvarProdutosCardapio($request, $cardapio->id);
            }
            while (strtotime($dataCriada) < strtotime($dataFim)) {
                $dataNova = date('Y-m-d', strtotime("+7 days",strtotime($dataCriada)));
                $dataCriada = $dataNova;
                echo $dataCriada."<br>";

                $c['data'] = $dataCriada;

                $c = $this->formatOutput($c);

                $cardapios = Cardapio::where(['data' => $c['data'], 'turno' => $c['turno']])->get();

                if (count($cardapios) > 0) {
                    $erros = $erros . $this->formatarDataBr($c['data']). ", ";
                }
                else {
                    $cardapio = Cardapio::create($c);
                    $this->salvarProdutosCardapio($request, $cardapio->id);
                }
            }

            if($erros == "")
                return redirect()
                    ->action('CardapioController@listar');
            else
                return redirect()
                    ->action('CardapioController@listar')
                    ->withErrors(array('Já existe um cardápio para os dias: '. $erros .'edite ou exclua se quiser um novo!'));

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
            unset($request['idsP']);
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
        $produtos = Produto::where(['id_empregador' => Auth::user()->id_empregador])->get();

        return parent::editarLote($request)
            ->with('produtos', $produtos);
    }

    public function atualizarLote(Request $request)
    {
        $ids = explode('-', $request['ids']);
        if ($request->nome != "") {
            foreach ($ids as $id) {
                $this->removerProdutosCardapio($id);
                $this->salvarProdutosCardapio($request, $id);
            }
        }
        unset($request['produtos']);
        unset($request['idsP']);
        unset($request['nome']);
        unset($request['quantidade']);

        return parent::atualizarLote($request);
    }

    public function salvarProdutosCardapio($request, $id)
    {
        $idsProdutos = array();
        $nomesProdutos = array();
        $quantidadesProdutos = array();

        $i = 0;
        foreach ($request->idsP as $idProduto) {
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
        if (isset($request['data']))
            $request['data'] = $this->formatarDataEn($request['data']);

        return $request;
    }

    protected function formatInput($request)
    {
       $request->data = $this->formatarDataBr($request->data);
        return $request;
    }

    public function removerLote(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');

        $strIds = $request->all();
        $ids = explode('-', $strIds['ids']);

        $erros = "";
        foreach ($ids as $id) {
            if (is_numeric($id)) {
                $cardapio = Cardapio::find($id);
                $pedidos = $cardapio->pedidos;

                if (count($pedidos) > 0) {
                    $erros = $erros . $this->formatarDataBr($cardapio->data). " (".count($pedidos)." pedidos), ";
                }
                else
                    $cardapio->delete();
            }
        }
        if($erros == "")
            return redirect()
                ->action('CardapioController@listar');
        else
            return redirect()
                ->action('CardapioController@listar')
                ->withErrors(array('Impossível excluir cardapios com pedidos cadastraados: '. $erros .' os pedidos devem ser excluidos primeiro!'));
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
