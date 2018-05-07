<?php

namespace App\Http\Controllers;

use App\Gasto;
use App\Http\Requests\PerfilRequest;
use App\ProdutoPedido;
use App\User;
use App\Pedido;
use App\PermissaoClasse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PerfilController extends AbstractCrudController
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

    public function listarPerfil($id)
    {
        if(Auth::user()->id != $id) return redirect('error404');
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $usuario = User::find($id);

        $usuario -> consumo = number_format($usuario -> consumo, 2, ',', '.');

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

        $pedidos = Pedido::where(['id_usuario' => Auth::user()->id, 'id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$dateI, $dateF])->get();
        $consumo = 0;

        $this->formatInput($pedidos);

        $produtosPedidos = array();

        foreach ($pedidos as $pedido) {
            //Calculando o custo total
            $preco = explode(" ", $pedido->preco);
            $preco[1] = str_replace(",", ".", $preco[1]);

            $consumo = $consumo + floatval($preco[1]);

            //Pegando produtos do pedido
            $produtosPedidos[$pedido->id] = ProdutoPedido::where(['id_pedido' => $pedido->id, 'id_empregador' => Auth::user()->id_empregador])->get();
            $produtosPedidos[$pedido->id]['id_pedido'] = $pedido->id;
            $pedido['diaSemana'] = $this->diaSemana($pedido->data);
        }

        return view('adm.perfil.perfil')
            ->with('usuario', $usuario)
            ->with('itensPermitidos', $itensPermitidos)
            ->with('consumo', $consumo)
            ->with('pedidos', $pedidos)
            ->with('produtosPedidos', $produtosPedidos);
    }

    public function editarPerfil($id)
    {
        if(Auth::user()->id != $id) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $usuario = User::find($id);

        return view('adm.perfil.formulario')
            ->with('action', 'users/atualizarPerfil/' . $id)
            ->with('usuario', $usuario)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function atualizarPerfil(Request $request, $id)
    {
        if(Auth::user()->id != $id) return redirect('error404');

        $dados = array (
            'email' => $request->email,
            'password' => $request->password != '' ? bcrypt($request->password) : ''
        );

        if($dados['password'] == '') {
            unset($dados['password']);
        }

        $usuario = User::find($id);
        $usuario->fill($dados);
        $usuario->save();

        return redirect('perfil/'.$id);
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

    protected function formatInput($request)
    {
        foreach ($request as $pedido) {
            $pedido['preco'] = "R$ ". number_format($pedido['preco'], 2, ',', '.');
        }

        return $request;
    }

	public function listarGastos($id, $ano)
	{
		if($this->checkPermissao()) return redirect('error404');
		$itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);
		if(Auth::user()->id != $id) {
			if(!array_key_exists('gestaoGastos', $itensPermitidos))
				return redirect('error404');
		}

		$usuarios = User::where(['status' => 1])->get();

		$usuarios = collect($usuarios)->sortBy('apelido');

		foreach ($usuarios as $u) {
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

			$u['consumo'] = $this->calculaConsumo($u['id'], $dateI, $dateF);
		}

		$usuario = $this->buscarLanche($ano, $id);

		return view('adm.perfil.gastos')
			->with('anoSelecionado', $ano)
			->with('usuario', $usuario)
			->with('usuarios', $usuarios)
			->with('itensPermitidos', $itensPermitidos);
	}

	public function novoGastos($mes, $ano, $idUsuario)
	{
		if (parent::checkPermissao()) return redirect('error404');
		$itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);
		if(Auth::user()->id != $idUsuario) {
			if(!array_key_exists('gestaoGastos', $itensPermitidos))
				return redirect('error404');
		}

		$gastos = Gasto::where(['mes' => $mes, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();

		if(count($gastos) > 0) {
			$gastos->almoco = number_format($gastos->almoco, 2, ',', '.');
			$gastos->sobremesa = number_format($gastos->sobremesa, 2, ',', '.');
			return view('adm.perfil.formularioGastos')
				->with('action', 'gastos/salvar/')
				->with('mes', $mes)
				->with('ano', $ano)
				->with('gastos', $gastos)
				->with('idUsuario', $idUsuario)
				->with('itensPermitidos', $itensPermitidos);
		}

		else {
			return view('adm.perfil.formularioGastos')
				->with('action', 'gastos/salvar/')
				->with('mes', $mes)
				->with('ano', $ano)
				->with('idUsuario', $idUsuario)
				->with('itensPermitidos', $itensPermitidos);
		}

	}

	public function salvarGastos(Request $request)
	{
		if($this->checkPermissao()) return redirect('error404');

		$dados = $this->formatOutput($request->except('_token'));
		$gasto = $dados['gasto'];
		unset($dados['salvar']);
		unset($dados['gasto']);

		$dados['almoco'] = str_replace('.', '', $dados['almoco']);
		$dados['almoco'] = str_replace(',', '.', $dados['almoco']);

		$dados['sobremesa'] = str_replace('.', '', $dados['sobremesa']);
		$dados['sobremesa'] = str_replace(',', '.', $dados['sobremesa']);

		if($gasto == '') {
			Gasto::create($dados);
		}
		else {
			$gastoE = Gasto::find($gasto);
			$gastoE->fill($dados);
			$gastoE->save();
		}

		return redirect('gastos/'.$dados['id_usuario'].'/'.$dados['ano']);
	}

	public function calculaConsumo ($idUsuario, $ini, $fim) {
		$pedidos = Pedido::where(['id_usuario' => $idUsuario, 'id_empregador' => Auth::user()->id_empregador])->whereBetween('data', [$ini, $fim])->get();

		$consumo  = 0;
		foreach ($pedidos as $pedido) {
			$consumo = $consumo + floatval($pedido->preco);
		}
		return $consumo;
	}

	public function buscarLanche($ano, $idUsuario) {
		$usuario = User::find($idUsuario);

		$bissexto = date('L', mktime(0, 0, 0, 1, 1, $ano));

		$usuario['lancheJaneiro'] = 	$this->calculaConsumo($idUsuario, $ano.'-01-01', $ano.'-01-31');
		$usuario['lancheFevereiro'] = 	$this->calculaConsumo($idUsuario, $ano.'-02-01', $ano.'-02-'.($bissexto ? '29' : '28'));
		$usuario['lancheMarco'] = 		$this->calculaConsumo($idUsuario, $ano.'-03-01', $ano.'-03-31');
		$usuario['lancheAbril'] = 		$this->calculaConsumo($idUsuario, $ano.'-04-01', $ano.'-04-30');
		$usuario['lancheMaio'] = 		$this->calculaConsumo($idUsuario, $ano.'-05-01', $ano.'-05-31');
		$usuario['lancheJunho'] = 		$this->calculaConsumo($idUsuario, $ano.'-06-01', $ano.'-06-30');
		$usuario['lancheJulho'] = 		$this->calculaConsumo($idUsuario, $ano.'-07-01', $ano.'-07-31');
		$usuario['lancheAgosto'] = 		$this->calculaConsumo($idUsuario, $ano.'-08-01', $ano.'-08-31');
		$usuario['lancheSetembro'] =	$this->calculaConsumo($idUsuario, $ano.'-09-01', $ano.'-09-30');
		$usuario['lancheOutubro'] = 	$this->calculaConsumo($idUsuario, $ano.'-10-01', $ano.'-10-31');
		$usuario['lancheNovembro'] = 	$this->calculaConsumo($idUsuario, $ano.'-11-01', $ano.'-11-30');
		$usuario['lancheDezembro'] = 	$this->calculaConsumo($idUsuario, $ano.'-12-01', $ano.'-12-31');

		$usuario['gastosJaneiro'] = 	Gasto::where(['mes' => 1, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosFevereiro'] = 	Gasto::where(['mes' => 2, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosMarco'] = 		Gasto::where(['mes' => 3, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosAbril'] = 		Gasto::where(['mes' => 4, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosMaio'] = 		Gasto::where(['mes' => 5, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosJunho'] = 		Gasto::where(['mes' => 6, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosJulho'] = 		Gasto::where(['mes' => 7, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosAgosto'] = 		Gasto::where(['mes' => 8, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosSetembro'] = 	Gasto::where(['mes' => 9, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosOutubro'] = 	Gasto::where(['mes' => 10, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosNovembro'] = 	Gasto::where(['mes' => 11, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();
		$usuario['gastosDezembro'] = 	Gasto::where(['mes' => 12, 'ano' => $ano, 'id_usuario' => $idUsuario])->first();

		return $usuario;
	}
}
