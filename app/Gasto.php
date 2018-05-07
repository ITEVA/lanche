<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
	public $timestamps = false;
	protected $guarded = ['id'];
	protected $table = 'gastos';
}
