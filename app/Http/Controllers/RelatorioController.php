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

    protected function listarPedidos()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $date = $this->dataAtual();
        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => Auth::user()->id , 'data' => $date, 'turno' => '1'])->get();

        return view('adm.relatorios.pedidos')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('pedidos', $pedidos)
            ->with('dataRe', date('d/m/Y'))
            ->with('turnoRe', '1');
    }

    protected function listarFiltroPedidos(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $date = $this->formatarDataEn($request->data);
        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => Auth::user()->id , 'data' => $date, 'turno' => $request->turno])->get();

        return view('adm.relatorios.pedidos')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('pedidos', $pedidos)
            ->with('dataRe', $request->data)
            ->with('turnoRe', $request->turno);
    }

    protected function pedidosImprimir(Request $request)
    {
        $date = $this->formatarDataEn($request->data);

        $pedidos = Pedido::where(['id_empregador' => Auth::user()->id_empregador, 'data' => $date, 'turno' => $request->turno])->get();

        foreach ($pedidos as $pedido) {
            //Pegando produtos do pedido
            $pedido['produtos'] = ProdutoPedido::where(['id_pedido' => $pedido->id, 'id_empregador' => Auth::user()->id_empregador])->get();
            $pedido['nomeUsuario'] = User::where(['id' => $pedido->id_usuario, 'id_empregador' => Auth::user()->id_empregador])->get();
        }

        $produtosGeral = DB::select("SELECT nome, SUM(lanche.produto_pedido.quantidade) as qtdTotal
                                FROM lanche.produto_pedido
                                where data = '{$date}'
                                AND turno = '{$request->turno}'
                                GROUP BY lanche.produto_pedido.nome");

        //Criando o objeto de PDF e inicializando suas configurações
        $pdf = new FPDF("P", "pt", "A4");

        //Adiciona uma nova pagina para cada colaborador
        $pdf->AddPage();

        //Desenha o cabeçalho do relatorio
        $pdf->Image('adm/images/logo1.png');
        $pdf->Line(20, 100 , 575, 100);

        $pdf->SetXY(0, 110);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(595, 14, "Relatório de pedidos dia: " . date('d/m/Y'), 0, 0, "C");

        //Tabela total de produtos
        $pdf->SetXY(20, 150);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(278, 20, 'Produto', 1, 0, "C");
        $pdf->Cell(278, 20, 'Quantidade', 1, 0, "C");

        //linhas da tabela
        $pdf->SetFont('arial', '', 10);
        if(count($produtosGeral) > 0) {
            $pdf->SetY($pdf->GetY() + 20);
            foreach ($produtosGeral as $produto) {
                $pdf->SetX(20);
                $pdf->Cell(278, 14, $produto->nome, 1, 0, "C");
                $pdf->Cell(278, 14, $produto->qtdTotal, 1, 0, "C");
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

        foreach ($pedidos as $pedido) {
            $pdf->AddPage();

            //Desenha o cabeçalho do relatorio
            $pdf->Image('adm/images/logo1.png');
            $pdf->Line(20, 100 , 575, 100);

            //Tabela total de produtos
            $pdf->SetXY(20, 150);
            $pdf->SetFont('arial', 'B', 10);
            $pdf->Cell(556, 20, $pedido['nomeUsuario'][0]['apelido'], 1, 0, "C");
            $pdf->SetXY(20, 170);
            $pdf->SetFont('arial', 'B', 10);
            $pdf->Cell(278, 20, 'Produto', 1, 0, "C");
            $pdf->Cell(278, 20, 'Quantidade', 1, 0, "C");

            //linhas da tabela
            $pdf->SetFont('arial', '', 10);
            if(count($pedido['produtos']) > 0) {
                $pdf->SetY($pdf->GetY() + 20);
                foreach ($pedido['produtos'] as $produto) {
                    $pdf->SetX(20);
                    $pdf->Cell(278, 14, $produto['nome'], 1, 0, "C");
                    $pdf->Cell(278, 14, $produto['quantidade'], 1, 0, "C");
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
        }

        $pdf->Output();
        exit;
    }

    public function teste(){
        $fpdf = new Fpdf();
        $usuarios = User::all();
        foreach( $usuarios as $usuario )
        {
            $fpdf->AddPage();
            $fpdf->Image('adm/images/perfil/' . $usuario->foto, 0, 0, 210, 270);
        }
        $fpdf->Output();
        exit;
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

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
