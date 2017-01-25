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
            'data' => '',
            'id_produto' => '',
            'id_usuario' => ''
        ];
    }
}
