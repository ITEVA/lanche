@extends('adm.layout.adm')
@section('css')
    <!-- Custom styling plus plugins -->
    <link href="adm/css/custom.css" rel="stylesheet">
    <link href="adm/css/icheck/flat/green.css" rel="stylesheet">
    <link href="adm/css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
@endsection
@section('conteudo')
<div class="">
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Pedidos cadastradas no sistema</h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form method="POST" action="relatorios/pedidos" enctype="multipart/form-data" id="filtro" data-parsley-validate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                        <div class="form-group col-md-1 col-xs-12">
                            <label for="data">Data</label>
                            <input type="text" class="form-control date-picker" name="data"
                                   value="{{old('data') !== null ? old('data') : $dataRe}}"/>
                        </div>

                        <div class="form-group col-md-1 col-xs-12">
                            <label>Turno</label><br/>
                            @if ((old('turno') !== null && old('turno') === '0') || (old('turno') === null && $turnoRe == '0'))
                                <input type="radio" class="flat" name="turno" value="1"/> Manhã
                                <input type="radio" class="flat" name="turno" checked="checked" value="0"/> Tarde
                            @else
                                <input type="radio" class="flat" name="turno" checked="checked" value="1"/> Manhã
                                <input type="radio" class="flat" name="turno" value="0"/> Tarde
                            @endif
                        </div>

                        <div class="form-group col-md-3 col-xs-12 quebrarDiv">
                            <input type="submit" name="filtrar" class="btn btn-success" value="Filtrar"/>
                            <input type="button" id="imprimirPedidos" name="imprimir" class="btn btn-success" value="Imprimir"/>
                        </div>
                    </form>

                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                        <tr class="headings">
                            <th id="checkboxs">
                            </th>
                            <th>Nome</th>
                            <th>Visualizar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($pedidos) > 0)
                            @foreach($pedidos as $pedido)
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>{{$pedido['nomeUsuario'][0]['nome']}}</td>
                                    <td><i class="fa fa-search detalhesPedido" iid="{{$pedido->id}}" style="cursor: pointer"></i></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="iconeListagem">Nenhum pedido encontrado</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <form id="formSelecionados" method="post" action="">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                        <input type="hidden" name="ids" id="ids" value=""/>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="alertRemover" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Remover registro</h4>
                        </div>
                        <div class="modal-body">
                            <p>Você deseja excluir este(s) registro(s)?</p>
                            <input type="hidden" id="tipoRemocao" value="" />
                        </div>
                        <div class="modal-footer">
                            <button id="confirmarRemocao" type="button" class="btn btn-danger">Sim</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            @foreach($pedidos as $pedido)
                <div class="modal fade" id="detalhesPedido{{$pedido->id}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Itens do pedido</h4>
                            </div>
                            <div class="modal-body">
                                <table class='table table-striped responsive-utilities jambo_table' id='addTr'>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Preço unitário</th>
                                        <th>Quantidade</th>
                                        <th>Preço total</th>
                                    </tr>
                                    @foreach($pedido['produtos'] as $produtoPedido)
                                        @if(isset($produtoPedido['id_pedido']))
                                            <tr>
                                                <td>{{$produtoPedido['nome']}}</td>
                                                <td>R$ {{number_format($produtoPedido['preco_unitario'], 2, ',', '.')}}</td>
                                                <td>{{str_replace(".", ",", $produtoPedido['quantidade'])}}</td>
                                                <td>R$ {{number_format($produtoPedido['preco_total'], 2, ',', '.')}}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </table>
                                <input type="hidden" id="tipoRemocao" value="" />
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            @endforeach
        </div>
    </div>
</div>
@stop
@section('js')
    <script src="adm/js/relatorios.js"></script>
    <!-- Datatables -->
    <script src="adm/js/datatables/js/jquery.dataTables.js"></script>
    <script src="adm/js/datatables/tools/js/dataTables.tableTools.js"></script>

    <script src="adm/js/datatables/js/formatoDataBr.js"></script>

    <!-- pace -->
    <script src="adm/js/pace/pace.min.js"></script>

    <!-- Listagem -->
    <script src="adm/js/listagem.js"></script>

    <script>
        $('input.tableflat').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

        var asInitVals = new Array();
        var oTable = $('#example').dataTable({
            "bPaginate": false,
            "order": [[1, "asc"]],
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar: ",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "aoColumnDefs": [
                {'bSortable': false,
                    'aTargets': [0]},
                {'bSortable': false,
                    'aTargets': [2]}
            ],
            'iDisplayLength': 10,
            "sPaginationType": "full_numbers"
        });
        $("tfoot input").keyup(function () {
            /* Filter on the column based on the index of this element's parent <th> */
            oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
        });
        $("tfoot input").each(function (i) {
            asInitVals[i] = this.value;
        });
        $("tfoot input").focus(function () {
            if (this.className == "search_init") {
                this.className = "";
                this.value = "";
            }
        });
        $("tfoot input").blur(function (i) {
            if (this.value == "") {
                this.className = "search_init";
                this.value = asInitVals[$("tfoot input").index(this)];
            }
        });

        $('.iCheck-helper').click(function(){
            if($(this).parent().parent().attr('id') === "checkboxs"){
                $('.iCheck-helper').each(function(){
                    if($(this).parent().parent().attr('id') !== "checkboxs") {
                        $(this).click();
                    }
                });
            }
        });
    </script>
@endsection