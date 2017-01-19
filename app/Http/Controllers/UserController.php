<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use App\Permissao;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends AbstractCrudController
{
    private $filtro = [];

    public function __construct()
    {
        parent::__construct('auth');
    }

    public function novo()
    {
        $permissoes = Permissao::where($this->getFilter())->get();

        return parent::novo()
            ->with('permissoes', $permissoes);
    }

    public function editar($id)
    {
        $permissoes = Permissao::where($this->getFilter())->get();

        return parent::editar($id)
            ->with('permissoes', $permissoes);
    }

    public function salvar(UserRequest $request)
    {
        $request['foto'] = $this->uploadImage($request);
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            return parent::salvarDados($request);

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar usuário. E-mail já cadastrado.'));
        }
    }

    public function atualizar(UserRequest $request, $id)
    {
        $request['foto'] = $this->uploadImage($request, $id);
        $request['id_empregador'] = Auth::user()->id_empregador;
        
        try {
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
        $permissoes = Permissao::where($this->getFilter())->get();

        return parent::editarLote($request)
            ->with('permissoes', $permissoes);
    }

    protected function removerFoto($object)
    {
        if($object->foto != 'default.jpg') {
            $nomeFoto = explode('.', $object->foto);
            if (file_exists("adm/images/perfil/$nomeFoto[0].jpg")) {
                unlink("adm/images/perfil/$nomeFoto[0].jpg");
                $i = 1;
                while (file_exists("adm/images/perfil/$nomeFoto[0].jpg")) {
                    unlink("adm/images/perfil/$nomeFoto[0].jpg");
                    $i++;
                }
            }
        }

        return ;
    }

    protected function formatOutput($request)
    {
        if($request['password'] !== ""){
            $request['password'] = bcrypt($request['password']);
        }else{
            unset($request['password']);
        }
        return $request;
    }

    protected function formatInput($request)
    {
        return parent::formatInput($request);
    }

    /**
     * Efetuar o upload da imagem de perfil do usuário
     * @param UsuarioRequest $request
     * @return string
     */
    private function uploadImage(UserRequest $request, $id = null)
    {
        $diretorio = 'adm/images/perfil/';
        $resultado = '';

        if ($request->hasFile('foto_user')) {
            $img_r = null;
            $nome = 'default';
            $extensao = '.png';
            $mime = $request->file('foto_user')->getMimeType();

            $nomeOriginal = $request->file('foto_user')->getClientOriginalName();
            $arquivo = explode('.', $nomeOriginal);

            $extensao = '.' . $arquivo[count($arquivo) - 1];

            $nome = $this->nomeUnico($diretorio, basename($nomeOriginal, $extensao), $extensao);

            if ($mime === 'image/jpeg') $img_r = imagecreatefromjpeg($request->file('foto_user'));
            elseif ($mime === 'image/png') $img_r = imagecreatefrompng($request->file('foto_user'));

            $extensao = '.jpg';
            imagejpeg($img_r, "{$diretorio}{$nome}{$extensao}");

            $resultado = "{$nome}{$extensao}";
        }else if($id !== null){
            $user = User::find($id);
            $resultado = $user->foto;
            $arquivo = explode('.', $resultado);

            $extensao = '.' . $arquivo[count($arquivo) - 1];

            if($extensao === '.png') $img_r = imagecreatefrompng("{$diretorio}{$resultado}");
            else  $img_r = imagecreatefromjpeg("{$diretorio}{$resultado}");

        }else{
            $nome = 'default';
            $extensao = '.png';

            $img_r = imagecreatefrompng("{$diretorio}{$nome}{$extensao}");
            $nome = $this->nomeUnico($diretorio, $nome, $extensao);

            $extensao = '.jpg';
            imagejpeg($img_r, "{$diretorio}{$nome}{$extensao}");

            $resultado = "{$nome}{$extensao}";
        }

        if ($request['h'] > 0 && $request['w'] > 0) {
            $p = imagesy($img_r) / 150;

            $h = $request['h'] * $p;
            $w = $request['w'] * $p;

            $x = $request['x'] * $p;
            $y = $request['y'] * $p;

            $dst_r = ImageCreateTrueColor($w, $h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $w, $h, $w, $h);

        } else $dst_r = $img_r;


        imagejpeg($dst_r, "{$diretorio}{$resultado}");

        unset($request['image']);
        unset($request['x']);
        unset($request['y']);
        unset($request['w']);
        unset($request['h']);

        return $resultado;
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }

    private function nomeUnico($diretorio, $nome, $extensao){
        $i = 1;
        if (file_exists("{$diretorio}{$nome}{$extensao}")) {
            while (file_exists("{$diretorio}{$nome}_{$i}{$extensao}")) $i++;
            $nome .= "_{$i}";
        }

        return $nome;
    }
}
