<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Pedido;
use App\ProdutoPedido;
use Illuminate\Support\Facades\Auth;
use Anouar\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;

class RelatorioController extends AbstractCrudController
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

    /* Relatório de pedidos */
    protected function listarPedidos()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $date = $this->dataAtual();
        $turno = date('H:i') < '12:00' ? 1 : 0;
        $pedidos = $this->getPedidos($date, $turno);

        return view('adm.relatorios.pedidos')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('pedidos', $pedidos)
            ->with('dataRe', date('d/m/Y'))
            ->with('turnoRe', $turno);
    }

    protected function listarFiltroPedidos(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $date = $this->formatarDataEn($request->data);
        $pedidos = $this->getPedidos($date, $request->turno);

        return view('adm.relatorios.pedidos')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('pedidos', $pedidos)
            ->with('dataRe', $request->data)
            ->with('turnoRe', $request->turno);
    }

    protected function pedidosImprimir(Request $request)
    {
        $date = $this->formatarDataEn($request->data);
        $diaSemana = $this->diaSemana($date);

        $turno = $request->turno == 1 ? "Manhã" : "Tarde";

        $pedidos = $this->getPedidos($date, $request->turno);

        $produtosGeral = DB::select("SELECT nome_formado as nome, SUM(FLOOR(quantidade)) as qtdTotalInteiros, SUM(quantidade - FLOOR(quantidade)) * 2 as qtdTotalMeios
                                     FROM produto_pedido
                                     where data = '{$date}'
                                     AND turno = '{$request->turno}'
                                     GROUP BY nome_formado
                                     HAVING qtdTotalInteiros > 0
                                     OR qtdTotalMeios > 0");

        //Criando o objeto de PDF e inicializando suas configurações
        $pdf = new FPDF("P", "pt", "A4");

        $pdf->SetTitle('Lanche '. $turno .' - '. $request->data);

        //Adiciona uma nova pagina para cada colaborador
        $pdf->AddPage();

        //Desenha o cabeçalho do relatorio
        $pdf->Image('adm/images/logo1.png');
        $pdf->SetXY(245, 80);
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(595, 14, $diaSemana, 0, 0, "C");
        $pdf->Line(20, 100 , 575, 100);

        $pdf->SetXY(0, 115);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(595, 14, "RELATÓRIO DE PEDIDOS DIA: " . $request->data, 0, 0, "C");

        //Tabela total de produtos
        $pdf->SetXY(20, 145);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(278, 20, 'Produto', 1, 0, "C");
        $pdf->Cell(139, 20, 'Quantidade de inteiros', 1, 0, "C");
        $pdf->Cell(139, 20, 'Quantidade de meios', 1, 0, "C");

        //linhas da tabela
        $pdf->SetFont('arial', '', 10);
        if(count($produtosGeral) > 0) {
            $pdf->SetY($pdf->GetY() + 20);
            foreach ($produtosGeral as $produto) {
                $pdf->SetX(20);
                $pdf->Cell(278, 14, $produto->nome, 1, 0, "C");
                $pdf->Cell(139, 14, $produto->qtdTotalInteiros, 1, 0, "C");
                $pdf->Cell(139, 14, $produto->qtdTotalMeios, 1, 0, "C");
                $pdf->SetY($pdf->GetY() + 14);
            }
        }

        //Rodape
        $pdf->SetAutoPageBreak(5);
        $pdf->SetFont('arial', '', 10);
        $pdf->SetXY(20, -45);
        $pdf->Cell(555, 15, "Rodovia CE - 040 s/n - Aquiraz - CE - cep 61.700-000 - cx. postal 66 - fone (85) 3362-3210 - e-mail iteva@iteva.org.br", 'T', 0, 'C');
        $pdf->SetXY(20, -30);
        $pdf->Cell(555, 15, "www.iteva.org.br", 0, 0, 'C');

        $i = 0;
        $mod = 5;
        $linhas = 4;

        $posicaoPedidoUsuario = 0;

        foreach ($pedidos as $pedido) {
            if($i % $mod == 0) {
                $pdf->AddPage();

                //Desenha o cabeçalho do relatorio
                $pdf->Image('adm/images/logo1.png');
                $pdf->SetXY(245, 80);
                $pdf->SetFont('arial', '', 10);
                $pdf->Cell(595, 14, $diaSemana, 0, 0, "C");
                $pdf->Line(20, 100, 575, 100);

                $pdf->SetXY(0, 115);
                $pdf->SetFont('arial', 'B', 10);
                $pdf->Cell(595, 14, "PEDIDOS INDIVIDUAIS DIA: " . $request->data, 0, 0, "C");
                $posicaoPedidoUsuario = 0;
            }

            $posicaoPedidoUsuario = $posicaoPedidoUsuario == 0 ? $posicaoPedidoUsuario + 145 : $posicaoPedidoUsuario + 115;

            //Tabela total de produtos
            $pdf->SetXY(20, $posicaoPedidoUsuario);
            $pdf->SetFont('arial', 'B', 10);
            $pdf->Cell(556, 20, $pedido['nomeUsuario'][0]['apelido'], 1, 0, "C");
            $pdf->SetXY(20, $posicaoPedidoUsuario + 20);
            $pdf->SetFont('arial', 'B', 10);
            $pdf->Cell(278, 20, 'Produto', 1, 0, "C");
            $pdf->Cell(278, 20, 'Quantidade', 1, 0, "C");

            //linhas da tabela
            $pdf->SetFont('arial', '', 10);
            if(count($pedido['produtos']) > 0) {
                $pdf->SetY($pdf->GetY() + 20);
                $j = 0;
                while($j < $linhas) {
                    if($j == 0) {
                        foreach ($pedido['produtos'] as $produto) {
                            $pdf->SetX(20);
                            $pdf->Cell(278, 14, $produto['nome_formado'], 1, 0, "C");
                            $pdf->Cell(278, 14, $produto['quantidade'], 1, 0, "C");
                            $pdf->SetY($pdf->GetY() + 14);
                            $j++;
                        }
                    }
                    if($j < $linhas) {
                        $pdf->SetX(20);
                        $pdf->Cell(278, 14, '', 1, 0, "C");
                        $pdf->Cell(278, 14, '', 1, 0, "C");
                        $pdf->SetY($pdf->GetY() + 14);
                        $j++;
                    }
                }
            }

            if($i % $mod == 0) {
                //Rodape
                $pdf->SetAutoPageBreak(5);
                $pdf->SetFont('arial', '', 10);
                $pdf->SetXY(20, -45);
                $pdf->Cell(555, 15, "Rodovia CE - 040 s/n - Aquiraz - CE - cep 61.700-000 - cx. postal 66 - fone (85) 3362-3210 - e-mail iteva@iteva.org.br", 'T', 0, 'C');
                $pdf->SetXY(20, -30);
                $pdf->Cell(555, 15, "www.iteva.org.br", 0, 0, 'C');
            }

            $i++;
        }

        $pdf->Output();
        exit;
    }

    private function getPedidos($date, $turno)
    {
        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'data' => $date, 'turno' => $turno])->get();

        foreach ($pedidos as $pedido) {
            //Pegando produtos do pedido
            $pedido['produtos'] = ProdutoPedido::where(['id_pedido' => $pedido->id, 'id_empregador' => Auth::user()->id_empregador])->get();
            $pedido['nomeUsuario'] = User::where(['id' => $pedido->id_usuario, 'id_empregador' => Auth::user()->id_empregador])->get();
        }

        return $pedidos;
    }
    /* / Relatório de pedidos */

    /* Relatório de gastos */
    protected function listarGastos()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $intervalo = $this->intevaloMes();

        $usuarios = $this->getUsuarios($intervalo);

        $intervalo['ini']  = date('d/m/Y', strtotime($intervalo['ini']));
        $intervalo['fim']  = date('d/m/Y', strtotime($intervalo['fim']));

        return view('adm.relatorios.gastos')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('usuarios', $usuarios)
            ->with('intervalo', $intervalo);
    }

    protected function listarFiltroGastos(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $intervalo = array(
                "ini" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataIni))),
                "fim" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataFim)))
        );

        $usuarios = $this->getUsuarios($intervalo);

        $intervalo['ini']  = date('d/m/Y', strtotime($intervalo['ini']));
        $intervalo['fim']  = date('d/m/Y', strtotime($intervalo['fim']));

        return view('adm.relatorios.gastos')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('usuarios', $usuarios)
            ->with('intervalo', $intervalo);
    }

    protected function gastosImprimir(Request $request)
    {
        $intervalo = array(
            "ini" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataIni))),
            "fim" => date('Y-m-d', strtotime(str_replace('/', '-', $request->dataFim)))
        );

        $usuarios = $this->getUsuarios($intervalo);

        //Criando o objeto de PDF e inicializando suas configurações
        $pdf = new FPDF("P", "pt", "A4");

        $pdf->SetTitle('Gstos: '. $request->dataIni. '-'. $request->dataFim);

        //Adiciona uma nova pagina para cada colaborador
        $pdf->AddPage();

        //Desenha o cabeçalho do relatorio
        $pdf->Image('adm/images/logo1.png');
        $pdf->Line(20, 100 , 575, 100);

        $pdf->SetXY(0, 115);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(595, 14, "GASTOS: ". $request->dataIni. '-'. $request->dataFim, 0, 0, "C");

        //Tabela total de produtos
        $pdf->SetXY(20, 145);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(278, 20, 'nome', 1, 0, "C");
        $pdf->Cell(278, 20, 'Gasto Total', 1, 0, "C");

        //linhas da tabela
        $pdf->SetFont('arial', '', 10);
        if(count($usuarios) > 0) {
            $pdf->SetY($pdf->GetY() + 20);
            foreach ($usuarios as $usuario) {
                $pdf->SetX(20);
                $pdf->Cell(278, 14, $usuario->nome, 1, 0, "C");
                $pdf->Cell(278, 14, $usuario['consumo'], 1, 0, "C");
                $pdf->SetY($pdf->GetY() + 14);
            }
        }

        //Rodape
        $pdf->SetAutoPageBreak(5);
        $pdf->SetFont('arial', '', 10);
        $pdf->SetXY(20, -45);
        $pdf->Cell(555, 15, "Rodovia CE - 040 s/n - Aquiraz - CE - cep 61.700-000 - cx. postal 66 - fone (85) 3362-3210 - e-mail iteva@iteva.org.br", 'T', 0, 'C');
        $pdf->SetXY(20, -30);
        $pdf->Cell(555, 15, "www.iteva.org.br", 0, 0, 'C');

        $pdf->Output();
        exit;
    }

    protected function getUsuarios ($intervalo)
    {
        $usuarios = User::where($this->getFilter())->orderBy('nome', 'asc')->get();

        foreach ($usuarios as $usuario) {
            $usuario['pedidos'] = Pedido::where(['id_usuario' => $usuario->id, 'id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$intervalo['ini'], $intervalo['fim']])->get();
            $consumo  = 0;
            foreach ($usuario['pedidos'] as $pedido) {
                $consumo = $consumo + floatval($pedido->preco);
            }
            $usuario['consumo'] = "R$ " . number_format($consumo, 2, ',', '.');
        }

        return $usuarios;
    }
    /* / Relatório de gastos */

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

    private function formatarDataEn($dataBr)
    {
        $date = implode("-",array_reverse(explode("/", $dataBr)));
        return date('Y-m-d', strtotime($date));
    }

    private function dataAtual()
    {
        date_default_timezone_set('America/Fortaleza');
        return $date = date('Y-m-d');
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

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
