<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoPedido extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'produto_pedido';

    public static function getEmpty(){
        return (object)[
            'nome' => '',
            'quantidade' => '',
            'preco_unitario' => '',
            'preco_total' => '',
            'id_pedido' => '',
            'id_empregador' => ''
        ];
    }
}
