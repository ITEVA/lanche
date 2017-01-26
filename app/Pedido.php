<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'pedidos';

    public static function getEmpty(){
        return (object)[
            'preco' => '',
            'observacao' => '',
            "corrigido" => '',
            "motivo_correcao" => '',
            "data_correcao" => '',
            'data' => '',
            'id_produto' => '',
            'id_usuario' => ''
        ];
    }
}
