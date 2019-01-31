<?php

namespace App\Http\Controllers;

use App\Almoco;
use App\AlmocoUsuario;
use App\Cardapio;
use App\InformacaoGeral;
use App\Produto;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlmocoController extends AbstractCrudController
{
	private $filtro = [];

	public function __construct()
	{
		parent::__construct('auth');
	}

	public function listar()
	{
		$almoco = Almoco::where(['data' => date('Y-m-d')])->get();

		return parent::listar()
			->with('disabled', count($almoco) > 0 ? 1 : 0);
	}

	public function novoAnterior()
	{
		if (parent::checkPermissao()) return redirect('error404');
		$itensPermitidos = parent::getClassesPermissao(Auth::user()->permissao);

		return view('adm.almocos.formularioDataAnterior')
			->with('action', 'almocos/salvarAnterior')
			->with('itensPermitidos', $itensPermitidos);
	}

	public function novo()
	{
		$almoco = Almoco::where(['data' => date('Y-m-d')])->get();
		if(count($almoco) > 0)
			return redirect('almocos');

		$usuarios = User::where(['status'=>1])->orderBy('apelido','asc')->get();
		$cardapio = Cardapio::where(['data' => date('Y-m-d'), 'turno' => 1])->get();

		$sobremesas = array();
		if(count($cardapio) > 0) {
			foreach ($cardapio[0]->produtosCardapio as $produto) {
				if ($produto->produto->sobremesa)
					$sobremesas[] = $produto;
			}
		}

		return parent::novo()
			->with('sobremesas', $sobremesas)
			->with('usuarios', $usuarios);
	}

	public function editar($id)
	{
		$almoco = Almoco::find($id);
		$usuarios = $almoco->itens;
		foreach ($usuarios as $usuario) {
			$usuario['apelido'] = $usuario->usuario->apelido;
		}

		$usuarios = collect($usuarios)->sortBy('apelido');
		$cardapio = Cardapio::where(['data' => $almoco->data, 'turno' => 1])->get();

		$sobremesas = array();
		if(count($cardapio) > 0) {
			foreach ($cardapio[0]->produtosCardapio as $produto) {
				if ($produto->produto->sobremesa)
					$sobremesas[] = $produto;
			}
		}

		return parent::editar($id)
			->with('sobremesas', $sobremesas)
			->with('usuarios', $usuarios);
	}

	public function salvarAnterior(Request $request)
	{
		if (parent::checkPermissao()) return redirect('error404');

		try {
			$dados['data'] = $this->formatDateEn($request->data);
			$dados['id_empregador'] = Auth::user()->id_empregador;
			$almoco = Almoco::create($dados);

			$usuarios = User::where(['status'=>1])->orderBy('apelido','asc')->get();

			foreach ($usuarios as $usuario) {
				$dadosProduto = array (
					"peso" => "",
					"id_almoco" => $almoco->id,
					"id_usuario" => $usuario->id,
					"id_empregador" => Auth::user()->id_empregador
				);

				AlmocoUsuario::create($dadosProduto);
			}

			return redirect('almocos/editar/'.$almoco->id);
		} catch (QueryException $e) {
			return redirect()
				->back()
				->withInput()
				->withErrors(array('Erro ao salvar. Tente mais tarde'));
		}
	}

	public function salvar(Request $request)
	{
		if (parent::checkPermissao()) return redirect('error404');

		$request['id_empregador'] = Auth::user()->id_empregador;

		try {
			$idAlmoco = $this->salvarItens($request);

			return redirect('almocos/editar/'.$idAlmoco);
		} catch (QueryException $e) {
			return redirect()
				->back()
				->withInput()
				->withErrors(array('Erro ao salvar fornecedor. Tente mais tarde'));
		}
	}

	public function atualizar(Request $request, $id)
	{
		$request['id_empregador'] = Auth::user()->id_empregador;

		try {
			$this->removerItens($id);
			$idAlmoco = $this->salvarItens($request, $id);

			return redirect('almocos/editar/'.$idAlmoco);
		} catch (QueryException $e) {
			return redirect()
				->back()
				->withInput()
				->withErrors(array($e->getMessage()));
		}
	}

	private function salvarItens($request, $id = null)
	{
		$idsUsuario = $request->id_usuario;
		$pesos = $request->peso;
		$idsSobremesa = $request->id_sobremesa;

		$request->offsetUnset('id_usuario');
		$request->offsetUnset('peso');
		$request->offsetUnset('id_sobremesa');

		$dados = $this->formatOutput($request->except('_token'));

		if (isset($dados['salvar']))
			unset($dados['salvar']);

		if ($id != null) {
			$almoco = Almoco::find($id);
		}
		else {
			$dados['data'] = date("Y-m-d");
			$almoco = Almoco::create($dados);
		}

		$ig = InformacaoGeral::find(1);

		if($idsUsuario[0] != '') {
			$i = 0;
			foreach ($idsUsuario as $idUsuario) {
				$sobremesa = Produto::find($idsSobremesa[$i]);
				$dadosProduto = array (
					"peso" => isset($pesos[$i]) ? $pesos[$i] : '',
					"sobremesa" => isset($pesos[$i]) ? $idsSobremesa[$i] : '',
					"valor_sobremesa" => isset($pesos[$i]) ? $sobremesa['preco'] : '',
					"valor_kg" => $ig->valor_kg,
					"id_almoco" => $almoco->id,
					"id_usuario" => $idUsuario,
					"id_empregador" => Auth::user()->id_empregador
				);

				if($dadosProduto['sobremesa'] == '')
					unset($dadosProduto['sobremesa']);

				AlmocoUsuario::create($dadosProduto);

				$i++;
			}
		}

		return $almoco->id;
	}

	private function removerItens($id)
	{
		$usuariosAlmoco = AlmocoUsuario::where(['id_empregador' => Auth::user()->id_empregador, 'id_almoco' => $id])->get();
		foreach ($usuariosAlmoco as $usuarioAlmoco) {
			$usuarioAlmoco->delete();
		}
	}

	protected function formatOutput($request)
	{
		return $request;
	}

	protected function formatInput($request)
	{
		return $request;
	}

	protected function getFilter()
	{
		return ['id_empregador' => Auth::user()->id_empregador];
	}
}
