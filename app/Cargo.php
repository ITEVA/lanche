<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
	public $timestamps = false;
	protected $guarded = ['id'];
	protected $table = 'cargos';

	public static function getEmpty(){
		return (object)[
			'nome' => '',
			'descricao' => '',
			'valor' => ''
		];
	}

	public function classesCargo()
	{
		return $this->hasMany('App\CargoClasse', 'id_cargo');
	}
}
