@extends('adm.layout.adm')
@section('css')
    <link href="adm/css/pedidos.css" rel="stylesheet">
    <!-- select2 -->
    <link href="adm/css/select/select2.min.css" rel="stylesheet">
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
                    @if (count($errors) > 0)
                        <ul style="color: red;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if(isset($actionFiltro))
                        <!-- start form for validation -->
                        <form method="POST" action="{{$actionFiltro}}" enctype="multipart/form-data"
                              data-parsley-validate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <div class="form-group col-md-2 col-xs-12 quebrarDiv">
                                <label>Cardapios*</label>
                                <select id="cardapios" name="cardapio" class="select2_single form-control">
                                    <option selected="selected" class="produto" value="">Selecione um produto
                                    </option>
                                    @if (count($cardapios) > 0)
                                        @foreach ($cardapios as $cardapioF)
                                            <option {{isset($cardapio) ? ($cardapioF->id == old('cardapio') || (old('cardapio') === null && $cardapioF->id == $cardapio[0]->id) ? 'selected="selected"' : '') : ''}}
                                                    class="cardapio" value="{{$cardapioF->id}}">{{date("d/m/Y", strtotime($cardapioF->data))}} - {{$cardapioF->turno == 1 ? "Manhã" : "Tarde"}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group  col-md-12 col-xs-12">
                                <input type="submit" name="salvar" value="Filtrar" class="btn btn-success">
                                @if(!isset($produtos))
                                    <a href="pedidos/corrigir">Voltar</a>
                                @endif
                            </div>
                            <div class="ln_solid col-md-12 col-xs-12"></div>
                        </form>
                        <!-- end form for validations -->
                    @endif
                    @if(isset($produtos))
                        <!-- start form for validation -->
                            <form method="POST" action="{{$action}}" enctype="multipart/form-data" id="frmPedido"
                                  data-parsley-validate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                <input type="hidden" name="cardapio" value="{{$cardapio[0]['id']}}" />

                                <div class="form-group col-md-12 col-xs-12">
                                    <label class="destaque">{{isset($cardapio[0]->descricao) ? $cardapio[0]->descricao : ''}}</label>
                                </div>

                                @if(isset($usuarios))
                                    <div class="form-group col-md-2 col-xs-12">
                                        <label>Usuário*</label>
                                        <select id="usuarios" name="usuario" class="select2_single form-control">
                                            <option selected="selected" value="">Selecione um produto
                                            </option>
                                            @if (count($usuarios) > 0)
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{$usuario->id}}">{{$usuario->apelido}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="usuario" value="{{$pedido->id_usuario}}" />
                                @endif

                                <div class="form-group col-md-5 col-xs-12 quebrarDiv">
                                    <label for="motivo_correcao">Motivo*</label>
                                    <textarea id="motivoCorrecao" class="form-control" name="motivo_correcao">{{old('motivo_correcao') !== null ? old('motivo_correcao') : $pedido->motivo_correcao}}</textarea>
                                </div>

                                <div class="form-group col-md-2 col-xs-12 quebrarDiv">
                                    <label>Produtos*</label>
                                    <select id="produtos" name="produtos" class="select2_single form-control">
                                        <option selected="selected" class="produto" value="">Selecione um produto
                                        </option>
                                        @if (count($produtos) > 0)
                                            @foreach ($produtos as $produto)
                                                <option nomeE="{{$produto->nome}}" precoE="{{$produto->preco}}" class="produto" value="{{$produto->id}}">{{$produto->nome}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <br>
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
                                                    <td><label class="precoUnitario">{{"R$ ". number_format($produtoPedido->preco_unitario, 2, ',', '.')}}</label></td>
                                                    <td><input class="quantidadeProduto quantidade" type="text" value="{{str_replace(".", ",", $produtoPedido->quantidade)}}" min="1" max="50"></td>
                                                    <td class="td"><label class="precoProduto">R$ {{number_format($produtoPedido->preco_total, 2, ',', '.')}}</label></td>
                                                    <td><a href="" class="removerProduto"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>

                                    <div class="form-group col-md-3 col-xs-12 pull-right">
                                        <label class="totalPedido">Total: R$</label>
                                        <label id="totalPedido" class="totalPedido">{{$pedido->preco == '' ? '' : number_format($pedido->preco, 2, ',', '.')}}</label>
                                    </div>
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
                                    <input id="salvarPedido" type="submit" name="salvar" value="Salvar" class="btn btn-success">
                                    <a href="pedidos/corrigir">Voltar</a>
                                </div>
                                <div class="form-group  col-md-12 col-xs-12">
                                    <p></p>
                                </div>
                            </form>
                            <!-- end form for validations -->
                    @endif
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
    <div class="modal fade" id="erroSalvar" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Erro ao salvar pedido</h4>
                </div>
                <div class="modal-body">
                    <p>Para salvar o pedido adicione algum produto!</p>
                    <input type="hidden" id="tipoRemocao" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="erroMotivo" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Erro ao salvar pedido</h4>
                </div>
                <div class="modal-body">
                    <p>Preencha o campo motivo!</p>
                    <input type="hidden" id="tipoRemocao" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="erroUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Erro ao salvar pedido</h4>
                </div>
                <div class="modal-body">
                    <p>Selecione um usuário!</p>
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
    <!-- select2 -->
    <script src="adm/js/select/select2.full.js"></script>
    <!-- select2 -->
    <script>
        $(document).ready(function() {
            $(".select2_single").select2({
                placeholder: "Selecione um item",
                allowClear: true
            });
        });
    </script>
@endsection