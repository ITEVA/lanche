<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'permissoes';

    public static function getEmpty(){
        return (object)[
            'nome' => '',
            'descricao' => ''
        ];
    }
}