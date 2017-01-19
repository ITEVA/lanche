@extends('adm.layout.adm')
@section('conteudo')

    <link href="adm/css/perfil.css" rel="stylesheet">

    <div class="col-lg-12 conteudoPrincipal">
        <div class="col-lg-2">
            <img src="adm/images/perfil/{{Auth::user()->foto}}" alt="..." class="img-circle profile_img">
        </div>

        <div class="col-lg-10 usuario">
            <p class="pInxirido">{{$usuario->nome}}</p>
            <p class="normal">{{$usuario->cargo}}</p>

            <p class="pInxirido">Gasto atual:<p class="normal">R$ {{$consumo}}</p></p>
        </div>

        <div class="col-lg-12">
            <table class="table table-striped responsive-utilities jambo_table">
                <tr>
                    <th>Data</th>
                    <th>Preço</th>
                    <th>Visualizar</th>
                </tr>
                @foreach($pedidos as $pedido)
                    <tr class="produtosTabela">
                        <td><label class="nomeProduto">{{$pedido->data}}</label></td>
                        <td><label class="precoUnitario">{{$pedido->preco}}</label></td>
                        <td><i class="fa fa-search"></i></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


@stop