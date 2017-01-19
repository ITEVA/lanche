<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilRequest;
use App\User;
use App\Pedido;
use App\PermissaoClasse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PerfilController extends Controller
{
    public function listar($id)
    {
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

        foreach ($pedidos as $pedido) {
            $consumo = $consumo + $pedido->preco;
        }

        return view('adm.perfil.perfil')
            ->with('usuario', $usuario)
            ->with('itensPermitidos', $itensPermitidos)
            ->with('consumo', $consumo)
            ->with('pedidos', $pedidos);
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
        $permissoes = PermissaoClasse::where(['classe'=>'perfil', 'id_empregador' => Auth::user()->id_empregador])->get();
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
}
