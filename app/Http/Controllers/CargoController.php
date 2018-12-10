<?php

namespace App\Http\Controllers;

use App\Http\Requests\CargoRequest;
use App\Cargo;
use App\User;
use App\InformacaoGeral;
use App\CargoClasse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CargoController extends AbstractCrudController
{

	public function listar()
	{
		return parent::listar();
	}

	public function salvar(CargoRequest $request)
	{
		$request['id_empregador'] = Auth::user()->id_empregador;

		try {
			if($request['descricao'] == null){
				$request['descricao'] = 'Sem descrição.';
			}
			return parent::salvarDados($request);
		} catch (QueryException $e) {
			return redirect()
				->back()
				->withInput()
				->withErrors(array('Erro ao salvar usuário. E-mail já cadastrado.'));
		}
	}

	public function atualizar(CargoRequest $request, $id)
	{
		$request['id_empregador'] = Auth::user()->id_empregador;

		try {
			if($request['descricao'] == null){
				$request['descricao'] = 'Sem descrição.';
			}
			return parent::atualizarDados($request, $id);
		} catch (QueryException $e) {
			return redirect()
				->back()
				->withInput()
				->withErrors(array($e->getMessage()));
		}
	}

	public function editar($id)
	{
		$cargos = Cargo::where($this->getFilter())->orderBy('nome', 'asc')->get();
		return parent::editar($id)
			->with('cargos', $cargos);
	}

	public function removerLote(Request $request)
	{
		if ($this->checkStatus()) return redirect('sair');
		if ($this->checkPermissao()) return redirect('error404');

		$strIds = $request->all();
		$ids = explode('-', $strIds['ids']);
		foreach ($ids as $id) {
			if (is_numeric($id)) {
				$user = User::where(['id_cargo' => $id])->get();

				if (count($user) == 0) {
					$cargo = Cargo::find($id);
					$cargo->delete();
				} else {
					$cargos = Cargo::all();
					return redirect()
						->back()
						->withInput()
						->withErrors(array('Cargo que esta sendo usado não pode ser apagado.'));
				}
			}
		}
		return redirect()
			->action('CargoController@listar');
	}
}
