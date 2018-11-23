<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'produtos';

    public static function getEmpty(){
        return (object)[
            'nome' => '',
            'preco' => '',
            'especificacao' => '',
            'sobremesa' => '0'
        ];
    }
}
