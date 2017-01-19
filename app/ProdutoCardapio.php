<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoCardapio extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'produto_cardapio';

    public static function getEmpty(){
        return (object)[
            'id_produto' => '',
            'id_cardapio' => '',
            'id_empregador' => ''
        ];
    }
}
