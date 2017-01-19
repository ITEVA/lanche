<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissaoClasse extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'permissoes_classes';
}
