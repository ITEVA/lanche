<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almoco extends Model
{
	public $timestamps = false;
	protected $guarded = ['id'];
	protected $table = 'almoco';

	public static function getEmpty(){
		return (object)[
			'data' => ''
		];
	}

	public function itens()
	{
		return $this->hasMany('App\AlmocoUsuario', 'id_almoco');
	}
}
