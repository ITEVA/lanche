@extends('adm.layout.adm')

@section('css')
    <!-- select2 -->
    <link href="adm/css/select/select2.min.css" rel="stylesheet">

    <link href="adm/css/cardapios.css" rel="stylesheet">
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
                    <form method="POST" action="{{$action}}" enctype="multipart/form-data" id="formCardapio"
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

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="data">Data inicio</label>
                            <input type="text" class="form-control date date-picker" name="dataIni"
                                   value="{{old('data') !== null ? old('data') : ''}}"/>
                        </div>

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="data">Data fim</label>
                            <input type="text" class="form-control date date-picker" name="dataFim"
                                   value="{{old('data') !== null ? old('data') : ''}}"/>
                        </div>

                        <div class="form-group col-md-5 col-xs-12 quebrarDiv">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" name="descricao">{{old('descricao') !== null ? old('descricao') : $cardapio->descricao}}</textarea>
                        </div>

                        <div class="form-group col-md-3 col-xs-12 quebrarDiv">
                            <label for="hora_inicio">Hora Início</label>
                            <input type="time" class="form-control" name="hora_inicio"
                                   value="{{old('hora_inicio') !== null ? old('hora_inicio') : $cardapio->hora_inicio}}"/>
                        </div>

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="hora_final">Hora Final</label>
                            <input type="time" class="form-control" name="hora_final"
                                   value="{{old('hora_final') !== null ? old('hora_final') : $cardapio->hora_final}}"/>
                        </div>

                        <div class="form-group col-md-1 col-xs-12">
                            <label>Turno</label><br/>
                            @if ((old('turno') !== null && old('turno') === '0') || (old('turno') === null && $cardapio->turno == '0'))
                                <input type="radio" class="flat" name="turno" value="1"/> Manhã
                                <input type="radio" class="flat" name="turno" checked="checked" value="0"/> Tarde
                            @else
                                <input type="radio" class="flat" name="turno" checked="checked" value="1"/> Manhã
                                <input type="radio" class="flat" name="turno" value="0"/> Tarde
                            @endif
                            @if(isset($ids))
                                <input type="radio" checked="checked" class="flat" name="turno" value=""/> NA
                            @endif
                        </div>

                        <div class="form-group col-md-2 col-xs-12 quebrarDiv">
                            <label>Produtos*</label>
                            <select id="produtos" name="produtos" class="select2_single form-control">
                                <option {{(isset($ids) ? 'selected="selected"' : "")}} selected="selected" class="produto" value="">Selecione um produto
                                </option>
                                @if (count($produtos) > 0)
                                    @foreach ($produtos as $produto)
                                        <option nomeE="{{$produto->nome}}" class="produto" value="{{$produto->id}}">{{$produto->nome}}</option>
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
                                    <th>Quantidade</th>
                                    <th>Excluir</th>
                                </tr>
                                @if(isset($produtosAtuais))
                                    @foreach($produtosAtuais as $produtoAtual)
                                        <tr class="produtosTabela" iid="{{$produtoAtual->id_produto}}" nomeProduto="{{$produtoAtual->nome}}">
                                            <td><label class="nomeProduto">{{$produtoAtual->nome}}</label></td>
                                            <td><input class="quantidadeProduto quantidadeCardapio" type="text" value="{{$produtoAtual->quantidade}}" min="1" max="1000"></td>
                                            <td><a href="" class="removerProduto"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>

                        <div class="selects">
                            <select  name="idsP[]" class="form-control selectIds" multiple="multiple">
                                @if(isset($produtosAtuais))
                                    @foreach($produtosAtuais as $produtoAtual)
                                        <option selected="selected" class="selectId" value="{{$produtoAtual->id_produto}}">{{$produtoAtual->id_produto}}</option>
                                    @endforeach
                                @endif
                            </select>

                            <select  name="nome[]" class="form-control selectNome" multiple="multiple">
                                @if(isset($produtosAtuais))
                                    @foreach($produtosAtuais as $produtoAtual)
                                        <option selected="selected" class="selectProduto" value="{{$produtoAtual->nome}}">{{$produtoAtual->nome}}</option>
                                    @endforeach
                                @endif
                            </select>

                            <select  name="quantidade[]" class="form-control selectQuantidade" multiple="multiple">
                                @if(isset($produtosAtuais))
                                    @foreach($produtosAtuais as $produtoAtual)
                                        <option selected="selected" class="selectQtd" value="{{$produtoAtual->quantidade}}">{{$produtoAtual->quantidade}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input id="salvarPedido" type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="cardapios">Voltar</a>
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
                    <p>O produto já está no seu cardápio!</p>
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
                    <p>Para salvar o cardápio adicione algum produto!</p>
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
    <script src="adm/js/cardapios.js"></script>

    <!-- select2 -->
    <script src="adm/js/select/select2.full.js"></script>
    <!-- form validation -->
    <!-- select2 -->
    <script>
        $(document).ready(function() {
            $(".select2_single").select2({
                placeholder: "Selecione um produto",
                allowClear: true
            });
        });
    </script>
    <!-- /select2 -->
@endsection