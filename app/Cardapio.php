<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'cardapio';

    public static function getEmpty(){
        return (object)[
            'data' => '',
            'descricao' => '',
            'hora_inicio' => '',
            'hora_final' => '',
            'id_produto' => '',
            'turno' => ''
        ];
    }

	public function produtosCardapio()
	{
		return $this->hasMany('App\ProdutoCardapio', 'id_cardapio');
	}

    public function pedidos()
    {
        return $this->hasMany('App\Pedido', 'id_cardapio');
    }
}
