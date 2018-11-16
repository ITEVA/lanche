<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlmocoUsuario extends Model
{
	public $timestamps = false;
	protected $guarded = ['id'];
	protected $table = 'almoco_usuario';

	public static function getEmpty(){
		return (object)[
			'peso' => '',
			'sobremesa' => '0'
		];
	}

	public function usuario()
	{
		return $this->belongsTo('App\User', 'id_usuario');
	}
}
