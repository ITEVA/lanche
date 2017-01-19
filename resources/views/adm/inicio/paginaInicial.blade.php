@extends('adm.layout.adm')

@section('conteudo')
    <div class="row conteudoPrincipal">
        <!-- top tiles -->
        <div class="row tile_count">
            <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-user"></i> Total de usuários</span>
                    <div class="count">{{count($usuarios)}}</div>
                    <span class="count_bottom"><i class="green"><a class="green" href="users">Ver mais!</a> </i></span>
                </div>
            </div>
            <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-lock"></i> Total de permissões</span>
                    <div class="count">{{count($permissoes)}}</div>
                    <span class="count_bottom"><i class="green"><a class="green" href="permissoes">Ver mais!</a> </i></span>
                </div>
            </div>
        </div>
        <!-- /top tiles -->
    </div>
@stop