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
            'quantidade' => '',
            'id_produto' => '',
            'id_cardapio' => '',
            'id_empregador' => ''
        ];
    }

	public function produto()
	{
		return $this->belongsTo('App\Produto', 'id_produto');
	}
}
