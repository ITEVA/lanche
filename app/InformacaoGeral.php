<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformacaoGeral extends Model
{
	public $timestamps = false;
	protected $guarded = ['id'];
	protected $table = 'informacoes_gerais';

	public static function getEmpty(){
		return (object)[
			'valor_kg' => ''
		];
	}
}
