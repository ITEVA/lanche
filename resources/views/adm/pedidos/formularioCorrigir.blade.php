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
                        <form method="POST" action="pedidos/corrigir/novo" enctype="multipart/form-data" id="filtro" data-parsley-validate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <div class="form-group col-md-1 col-xs-12">
                                <label for="data">Data inicio</label>
                                <input type="text" class="form-control date-picker" name="dataIni"
                                       value="{{old('dataIni') !== null ? old('dataIni') : $intervalo['ini']}}"/>
                            </div>

                            <div class="form-group col-md-1 col-xs-12">
                                <label for="data">Data fim</label>
                                <input type="text" class="form-control date-picker" name="dataFim"
                                       value="{{old('dataFim') !== null ? old('dataFim') : $intervalo['fim']}}"/>
                            </div>

                            <div class="form-group col-md-3 col-xs-12 quebrarDiv">
                                <input type="submit" name="filtrar" class="btn btn-success" value="Filtrar"/>
                            </div>
                        </form>
                        <!-- start form for validation -->
                        <form method="POST" action="{{$actionFiltro}}" enctype="multipart/form-data"
                              data-parsley-validate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <div class="form-group col-md-2 col-xs-12 quebrarDiv">
                                <label>Cardapios*</label>
                                <select id="cardapios" name="cardapio" class="select2_single form-control">
                                    <option selected="selected" class="produto" value="">Selecione um cardapio
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
                                <select id="produtos" name="produtos" class="select2_single form-control" pCarioca="{{$tipoPaes[0]->preco}}" pForma="{{$tipoPaes[1]->preco}}" pIntegral="{{$tipoPaes[2]->preco}}" pSovado="{{$tipoPaes[3]->preco}}" pMargarina="{{$tiposRecheio[0]->preco}}" pRequeijao="{{$tiposRecheio[1]->preco}}">
                                    <option {{(isset($ids) ? 'selected="selected"' : "")}} selected="selected" elemento="" class="produto" value="">Selecione um produto
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
                            <div class="form-group col-md-4 col-xs-12 "></div>

                            <div class="form-group col-md-3 col-xs-12 ">
                                <label>Legenda</label>
                                <table class='table table-striped responsive-utilities jambo_table'>
                                    <tr class="headings">
                                        <th class="tableStyle">Sigla</th>
                                        <th class="tableStyle">Representação</th>
                                        <th class="tableStyle">Valor</th>
                                    </tr>
                                    <tr>
                                        <td><label>PC</label></td>
                                        <td><label>{{$tipoPaes[0]->nome}}</label></td>
                                        <td><label>{{$tipoPaes[0]->preco}}</label></td>
                                    </tr>
                                    <tr>
                                        <td><label>PF</label></td>
                                        <td><label>{{$tipoPaes[1]->nome}}</label></td>
                                        <td><label>{{$tipoPaes[1]->preco}}</label></td>
                                    </tr>
                                    <tr>
                                        <td><label>PI</label></td>
                                        <td><label>{{$tipoPaes[2]->nome}}</label></td>
                                        <td><label>{{$tipoPaes[2]->preco}}</label></td>
                                    </tr>
                                    <tr>
                                        <td><label>PS</label></td>
                                        <td><label>{{$tipoPaes[3]->nome}}</label></td>
                                        <td><label>{{$tipoPaes[3]->preco}}</label></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group col-md-3 col-xs-12 ">
                                <label>Legenda</label>
                                <table class='table table-striped responsive-utilities jambo_table'>
                                    <tr class="headings">
                                        <th class="tableStyle">Sigla</th>
                                        <th class="tableStyle">Representação</th>
                                        <th class="tableStyle">Valor</th>
                                    </tr>
                                    <tr>
                                        <td><label>M</label></td>
                                        <td><label>{{$tiposRecheio[0]->nome}}</label></td>
                                        <td><label>{{$tiposRecheio[0]->preco}}</label></td>
                                    </tr><tr>
                                        <td><label>R</label></td>
                                        <td><label>{{$tiposRecheio[1]->nome}}</label></td>
                                        <td><label>{{$tiposRecheio[1]->preco}}</label></td>
                                    </tr>
                                    <tr>
                                        <td><label>N/A</label></td>
                                        <td><label>Sem nada</label></td>
                                        <td><label>0.00</label></td>
                                    </tr><tr>
                                        <td><label>C</label></td>
                                        <td><label>Chapado</label></td>
                                        <td><label>0.00</label></td>
                                    </tr>
                                    <tr>
                                        <td><label>N.C</label></td>
                                        <td><label>Não chapado</label></td>
                                        <td><label>0.00</label></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group col-md-3 col-xs-12 quebrarDiv">
                                <label>Disponibilidades de produtos: </label>
                            </div>
                            <div class="form-group col-md-12 col-xs-12 quebrarDiv">
                                @foreach ($produtos as $produto)
                                    @if($produto['quantidade'] != '')
                                        <div class="form-group col-md-3 col-xs-12">
                                            <label>{{$produto['nome']}}: </label>
                                            <input type="hidden" name="idDisponiveis[]" value="{{$produto->id}}"/>
                                            <input type="text" class="disponiveis" name="disponiveis[]" nomeP="{{$produto->nome}}" iid="{{$produto['nome']}}" id="{{$produto['id']}}" qtdDisponivel="{{$produto['quantidade']}}" value="{{$produto['quantidade']}}"/>
                                            <input type="hidden" name="quantidadesAnterior[]" value="{{isset($produto['qtdPedido']) ? $produto['qtdPedido'] : ''}}"/>
                                            <input type="hidden" name="quantidadesAtuais[]" class="quantidadeTotalPedido{{$produto->id}}" value="0"/>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="produtosPedidos">
                                <table class='table table-striped responsive-utilities jambo_table' id='addTr'>
                                    <tr>
                                        <th class="tableStyle">Produto</th>
                                        <th class="tableStyle">Preço unitário</th>
                                        <th class="tableStyle sanduicheTp {{$sanduiche == 0 ? "colunaInativa" : ""}}">Tipo de pão</th>
                                        <th class="tableStyle sanduicheTr {{$sanduiche == 0 && $pao == 0 && $tapioca == 0 ? "colunaInativa" : ""}}">Mant / Req</th>
                                        <th class="tableStyle sanduicheC {{$sanduiche == 0 && $pao == 0 ? "colunaInativa" : ""}}">Chap / N. Chap</th>
                                        <th class="tableStyle sanduiche {{$sanduiche == 0 && $pao == 0 && $tapioca == 0  ? "colunaInativa" : ""}}">Preço formado</th>
                                        <th class="tableStyle">Quantidade</th>
                                        <th class="tableStyle">Preço total</th>
                                        <th class="tableStyle">Excluir</th>
                                    </tr>
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <tr class="produtosTabela" iid="{{$produtoPedido->id_produto}}">
                                                <td><label id="nomeProduto" iid="{{$produtoPedido['idSanduiche']}}" nomeProduto="{{$produtoPedido->nome}}" class="nomeProduto">{{$produtoPedido->nome_formado}}</label></td>
                                                <td><label class="precoUnitario">{{"R$ ". number_format($produtoPedido->preco_unitario, 2, ',', '.')}}</label></td>
                                                <td class="sanduicheTp {{$sanduiche == 0 ? "colunaInativa" : ""}}">
                                                    @if($produtoPedido['sanduiche'] == 1)
                                                        <input class="tipoPao" type="radio" name="tipo_pao{{$produtoPedido['idSanduiche']}}" nomePao="{{$tipoPaes[0]->nome}}" {{$produtoPedido->tipo_pao == 'Pão carioca' ? "checked='checked'" : ""}} value="{{$tipoPaes[0]->preco}}"/>PC
                                                        <input class="tipoPao" id="paoPadrao" type="radio" name="tipo_pao{{$produtoPedido['idSanduiche']}}" nomePao="{{$tipoPaes[1]->nome}}" {{$produtoPedido->tipo_pao == 'Pão de forma' ? "checked='checked'" : ""}} value="{{$tipoPaes[1]->preco}}"/>PF
                                                        <input class="tipoPao" type="radio" name="tipo_pao{{$produtoPedido['idSanduiche']}}" nomePao="{{$tipoPaes[2]->nome}}" {{$produtoPedido->tipo_pao == 'Pão integral' ? "checked='checked'" : ""}} value="{{$tipoPaes[2]->preco}}"/>PI
                                                        <input class="tipoPao" type="radio" name="tipo_pao{{$produtoPedido['idSanduiche']}}" nomePao="{{$tipoPaes[3]->nome}}" {{$produtoPedido->tipo_pao == 'Pão sovado' ? "checked='checked'" : ""}} value="{{$tipoPaes[3]->preco}}"/>PS
                                                        <input class="tipoPaoDeducao" type="hidden" value="{{$produtoPedido->tipo_pao}}"/>
                                                    @endif
                                                </td>
                                                <td class="sanduicheTr {{$sanduiche == 0 && $pao == 0 && $tapioca == 0 ? "colunaInativa" : ""}}">
                                                    @if($produtoPedido['sanduiche'] == 1 || $produtoPedido['pao'] == 1 || $produtoPedido['tapioca'] == 1)
                                                        <input class="tipoRecheio" type="radio" name="tipo_recheio{{$produtoPedido['idSanduiche']}}" nomeRecheio="{{$tiposRecheio[0]->nome}}" {{$produtoPedido->tipo_recheio == 'Margarina' ? "checked='checked'" : ""}} value="{{$tiposRecheio[0]->preco}}"/>M
                                                        <input class="tipoRecheio" type="radio" name="tipo_recheio{{$produtoPedido['idSanduiche']}}" nomeRecheio="{{$tiposRecheio[1]->nome}}" {{$produtoPedido->tipo_recheio == 'Requeijão' ? "checked='checked'" : ""}} value="{{$tiposRecheio[1]->preco}}"/>R
                                                        <input class="tipoRecheio" type="radio" name="tipo_recheio{{$produtoPedido['idSanduiche']}}" nomeRecheio="Nada" {{$produtoPedido->tipo_recheio == 'Nada' ? "checked='checked'" : ""}} value="0.0"/> N/A
                                                    @endif
                                                </td>
                                                <td class="sanduicheC {{$sanduiche == 0 && $pao == 0 ? "colunaInativa" : ""}}">
                                                    @if($produtoPedido['sanduiche'] == 1 || $produtoPedido['pao'] == 1)
                                                        @if ($produtoPedido->chapado == 'Não chapado')
                                                            <input class="chapado" type="radio" nomeChapado="Chapado" name="chapado{{$produtoPedido['idSanduiche']}}" value="1"/> C
                                                            <input class="chapado" type="radio" nomeChapado="Não chapado" name="chapado{{$produtoPedido['idSanduiche']}}" checked="checked" value="0"/> N.C
                                                        @else
                                                            <input class="chapado" type="radio" nomeChapado="Chapado" name="chapado{{$produtoPedido['idSanduiche']}}" checked="checked" value="1"/> C
                                                            <input class="chapado" type="radio" nomeChapado="Não chapado" name="chapado{{$produtoPedido['idSanduiche']}}" value="0"/> N.C
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="sanduiche {{$sanduiche == 0 && $pao == 0 && $tapioca == 0 ? "colunaInativa" : ""}}">
                                                    <label class="precoFormado {{$produtoPedido['idSanduiche']}}">{{"R$ ". number_format($produtoPedido['valorFormado'], 2, ',', '.')}}</label>
                                                </td>
                                                <td>
                                                    <input qtd="{{str_replace(".", ",", $produtoPedido->quantidade)}}" class="quantidadeProduto quantidade" type="text" value="{{str_replace(".", ",", $produtoPedido->quantidade)}}" min="1" max="50">                                                    <input class="deduzido" type="hidden" value="{{str_replace(".", ",", $produtoPedido->quantidade)}}">
                                                </td>
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

                            <div class="selects">
                                <select  name="ids[]" class="form-control selectIds" multiple="multiple">
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <option selected="selected" class="selectId" value="{{$produtoPedido->id_produto}}">{{$produtoPedido->id_produto}}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <select  name="nome[]" class="form-control selectNome" multiple="multiple">
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <option selected="selected" class="selectProduto" iid="{{$produtoPedido['idSanduiche']}}" value="{{$produtoPedido->nome}}">{{$produtoPedido->nome}}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <select  name="nomeFormado[]" class="form-control selectNomeFormado" multiple="multiple">
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <option selected="selected" class="selectProdutoFormado" value="{{$produtoPedido->nome_formado}}">{{$produtoPedido->nome_formado}}</option>
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

                                <select  name="precoTotal[]" class="form-control selectPrecoFormado" multiple="multiple">
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <option selected="selected" class="selectPrecoTotal" value="{{$produtoPedido->preco_total}}">{{$produtoPedido->preco_total}}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <select  name="tipoPao[]" class="form-control selectTipoPao" multiple="multiple">
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <option selected="selected" class="selectPao" value="{{$produtoPedido->tipo_pao}}">{{$produtoPedido->tipo_pao}}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <select  name="tipoChapado[]" class="form-control selectTipoChapado" multiple="multiple">
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <option selected="selected" class="selectChapado" value="{{$produtoPedido->chapado}}">{{$produtoPedido->chapado}}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <select  name="tipoRecheio[]" class="form-control selectTipoRecheio" multiple="multiple">
                                    @if(isset($produtosPedido))
                                        @foreach($produtosPedido as $produtoPedido)
                                            <option selected="selected" class="selectRecheio" value="{{$produtoPedido->tipo_recheio}}">{{$produtoPedido->tipo_recheio}}</option>
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
                                <a href="pedidos">Voltar</a>
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
    <div class="modal fade" id="erroSalvarQuantidade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Erro ao salvar</h4>
                </div>
                <div class="modal-body">
                    <p>Cheque se os produtos pedidos estão disponíveis!</p>
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