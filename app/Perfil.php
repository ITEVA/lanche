<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'perfil';
}
