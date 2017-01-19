<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\PermissaoClasse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

abstract class AbstractCrudController extends Controller
{
    /** @var string */
    protected $model;

    /** @var string */
    protected $view;

    /** @var  string */
    protected $class;

    /** @var  string */
    protected $requestType;

    public function __construct($auth = null)
    {
        if($auth === 'auth') $this->middleware('auth');
        
        $this->model = 'App\\' . $this->getName();
        $this->view = strtolower($this->pluralize(2, $this->getName()));
        $this->class = strtolower($this->getName());
        $this->requestType = $this->getName() . 'Request';
    }

    public function listar()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $entity = $this->model;

        $entities = (count($this->getFilter()) ? $entity::where($this->getFilter())->get() : $entity::all());

        return view('adm.'.$this->view . '.listagem')
            ->with($this->view, $entities)
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function novo()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $entity = $this->model;
        $object = $entity::getEmpty();

        return view('adm.'.$this->view . '.formulario')
            ->with($this->class, $this->formatInput($object))
            ->with('action', $this->view . '/salvar')
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function editar($id)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        eval('$object=' . $this->model . '::find($id);');
        return view('adm.'.$this->view . '.formulario')
            ->with($this->class, $this->formatInput($object))
            ->with('action', $this->view . '/atualizar/' . $id)
            ->with('itensPermitidos', $itensPermitidos);
    }

    protected function salvarDados($request)
    {
        if($this->checkPermissao()) return redirect('error404');

        if(isset($request['salvar'])) unset($request['salvar']);
        $dados = $this->formatOutput($request->except('_token'));
        eval($this->model . '::create($dados);');

        return redirect()
            ->action($this->getName() . 'Controller@listar');
    }

    protected function atualizarDados($request, $id)
    {
        if($this->checkPermissao()) return redirect('error404');

        if(isset($request['salvar'])) unset($request['salvar']);
        eval('$object=' . $this->model . '::find($id);');
        $dados = $this->formatOutput($request->except('_token'));
        $object->fill($dados);
        $object->save();

        return redirect()
            ->action($this->getName() . 'Controller@listar');
    }

    public function editarLote(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao);

        $entity = $this->model;
        $object = $entity::getEmpty();

        $form = $request->all();

        return view('adm.'.$this->view . '.formulario')
            ->with($this->class, $this->formatInput($object))
            ->with('action', $this->view . '/atualizarLote')
            ->with('ids', $form['ids'])
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function atualizarLote(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');

        $request = $this->formatOutput($request->except('_token'));
        $entity = $this->model;
        $ids = explode('-', $request['ids']);
        $dados = array();
        foreach ($request as $key => $value) {
            if ($key !== "_token" && $key !== "ids" && $key !== "salvar" && $value !== "") {
                $dados[$key] = $value;
            }
        }

        foreach ($ids as $id) {
            if (is_numeric($id)) {
                try {
                    $object =  $entity::find($id);
                    $object->fill($dados);
                    $object->save();
                } catch (QueryException $e) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(array($e->getMessage()));
                }
            }
        }

        return redirect()
            ->action($this->getName() . 'Controller@listar');

    }

    public function removerLote(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');

        $strIds = $request->all();
        $ids = explode('-', $strIds['ids']);

        foreach ($ids as $id) {
            if (is_numeric($id)) {
                eval('$object=' . $this->model . '::find($id);');
                $this->removerFoto($object);
                $object->delete();
            }
        }
        return redirect()
            ->action($this->getName() . 'Controller@listar');
    }

    protected function getName()
    {
        $path = explode('\\', get_class($this));
        return str_replace("Controller", "", array_pop($path));
    }

    protected function pluralize($quantity, $singular, $plural = null)
    {
        if ($quantity == 1 || !strlen($singular)) return $singular;
        if ($plural !== null) return $plural;

        $last_letter = strtolower($singular[strlen($singular) - 1]);
        $penultimate_letter = strtolower($singular[strlen($singular) - 2]);

        if ($penultimate_letter == 'a' && $last_letter) {
            return substr($singular, 0, -2) . 'oes';
        }
        else {
            switch ($last_letter) {
                case 'y':
                    return substr($singular, 0, -1) . 'ies';
                case 's':
                    return $singular . 'es';
                default:
                    return $singular . 's';
            }
        }
    }

    protected function getClassesPermissao($id)
    {
        $permissoes = PermissaoClasse::where(['id_permissao'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();

        $itensPermitidos = array();

        foreach ($permissoes as $permissao) {
            $itensPermitidos[$permissao->classe] = 1;
        }

        return $itensPermitidos;
    }

    /**
     * Checa se o usuario logado tem permissão para acessar a classe solicitada
     * @return ctrl permissao concedida ou não
     */
    protected function checkPermissao()
    {
        $permissoes = PermissaoClasse::where(['classe'=>$this->class, 'id_empregador' => Auth::user()->id_empregador])->get();
        $i = 0;
        $ctrl = true;
        foreach ($permissoes as $permissao){
            if (Auth::user()->permissao == $permissao->id_permissao) {
                $ctrl = false;
            }
            $i++;
        }

        return $ctrl;
    }

    /**
     * Excluir as fotos da pasta
     * @param $id
     */
    protected function removerFoto($object)
    {
        return ;
    }

    /**
     * Formatação de dados para serem inseridos no sistema
     * @param $request
     * @return dados formatados
     */
    protected function formatOutput($request)
    {
        return $request;
    }

    /**
     * Formatação de dados para serem inseridos no formulario
     * @param $request
     * @return dados formatados
     */
    protected function formatInput($request)
    {
        return $request;
    }

    /**
     * Retorna um array com o filtro que será utilizado nas pesquisas
     */
    protected function getFilter()
    {
        return [];
    }

    /**
     * Recebe uma string de data no formato dd/mm/yyyy e retorna no formato yyyy-mm-dd
     * @param $dataOriginal
     * @return string
     */
    protected function formatDateEn($dataOriginal)
    {
        if ($dataOriginal !== "") {
            list($month, $day, $year) = explode('/', $dataOriginal);
            $date = Carbon::createFromDate($year, $day, $month);
            return $date->toDateTimeString();
        } else {
            return null;
        }
    }
    
    protected function removeMask($mask, $value)
    {
        foreach ($mask as $k => $v) $value = str_replace($k, $v, $value);
        return $value;
    }
}
