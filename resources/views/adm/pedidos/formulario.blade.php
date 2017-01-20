@extends('adm.layout.adm')
@section('css')
    <link href="adm/css/pedidos.css" rel="stylesheet">
@endsection
@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cadastro de Lanche</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- start form for validation -->
                    <form method="POST" action="{{$action}}" enctype="multipart/form-data" id="demo-form"
                          data-parsley-validate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        @if(isset($ids))
                            <input type="hidden" name="ids" value="{{$ids}}"/>
                        @endif
                        @if (count($errors) > 0)
                            <ul style="color: red;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <input type="hidden" name="cardapio" value="{{$cardapio[0]['id']}}" />

                        <div class="form-group col-md-2 col-xs-12">
                            <label>Produtos*</label>
                            <select id="produtos" name="produtos" class="form-control">
                                <option {{(isset($ids) ? 'selected="selected"' : "")}} selected="selected" elemento="" class="produto" value="">Selecione um produto
                                </option>
                                @if (count($produtos) > 0)
                                    @foreach ($produtos as $produto)
                                        <option nomeE="{{$produto[0]->nome}}" precoE="{{$produto[0]->preco}}" class="produto" value="{{$produto[0]->id}}">{{$produto[0]->nome}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <br>
                            <input type="button" id="addProduto" name="salvar" value="Adicionar" class="btn btn-success">
                        </div>

                        <div class="produtosPedidos">
                            <table class='table table-striped responsive-utilities jambo_table' id='addTr'>
                                <tr>
                                    <th>Produto</th>
                                    <th>Preço unitário</th>
                                    <th>Quantidade</th>
                                    <th>Preço total</th>
                                    <th>Excluir</th>
                                </tr>
                                @if(isset($produtosPedido))
                                    @foreach($produtosPedido as $produtoPedido)
                                        <tr class="produtosTabela">
                                            <td><label class="nomeProduto">{{$produtoPedido->nome}}</label></td>
                                            <td><label class="precoUnitario">R$ {{str_replace(".", ",", $produtoPedido->preco_unitario)}}</label></td>
                                            <td><input class="quantidadeProduto quantidade" type="text" value="{{str_replace(".", ",", $produtoPedido->quantidade)}}" min="1" max="50"></td>
                                            <td><label class="precoProduto">R$ {{str_replace(".", ",", $produtoPedido->preco_total)}}</label></td>
                                            <td><a href="" class="removerProduto"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>

                        <div class="selectsDuBom">
                            <select  name="nome[]" class="form-control selectNome" multiple="multiple">
                                @if(isset($produtosPedido))
                                    @foreach($produtosPedido as $produtoPedido)
                                        <option selected="selected" class="selectProduto" value="{{$produtoPedido->nome}}">{{$produtoPedido->nome}}</option>
                                    @endforeach
                                @endif
                            </select>

                            <select  name="quantidade[]" class="form-control selectQuantidade" multiple="multiple">
                                @if(isset($produtosPedido))
                                    @foreach($produtosPedido as $produtoPedido)
                                        <option selected="selected" class="selectQtd" value="{{$produtoPedido->quantidade}}">{{$produtoPedido->quantidade}}</option>
                                    @endforeach
                                @endif
                            </select>

                            <select  name="precoUnitario[]" class="form-control selectPrecoUnitario" multiple="multiple">
                                @if(isset($produtosPedido))
                                    @foreach($produtosPedido as $produtoPedido)
                                        <option selected="selected" class="selectPreco" value="{{$produtoPedido->preco_unitario}}">{{$produtoPedido->preco_unitario}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-5 col-xs-12 quebrarDiv">
                            <label for="observacao">Observação</label>
                            <textarea class="form-control" name="observacao">{{old('observacao') !== null ? old('observacao') : $pedido->observacao}}</textarea>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="pedidos">Voltar</a>
                        </div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <p></p>
                        </div>

                    </form>
                    <!-- end form for validations -->

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="alertRepetido" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Produto repetido</h4>
                </div>
                <div class="modal-body">
                    <p>O produto já está no seu pedido, para alterar a quantidade use o campo da tabela!</p>
                    <input type="hidden" id="tipoRemocao" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
@section('js')
    <script src="adm/js/pedidos.js"></script>
@endsection