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
                    <a class="btn btn-success pull-right" {{count($pedidos[0]['pedido']) != 0 ? " disabled data-toggle=popover data-placement=bottom data-trigger=hover" : " href=pedidos/novo "}}  data-content="Já existe um pedido para este turno">
                        <i class="fa fa-plus"></i>&nbsp;Novo
                    </a>

                    <a href="pedidos/removerLote" id="removerLote" style="display: none"></a>

                    <div class="x_title">
                        <h2>Pedido</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="example" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                            <tr class="headings">
                                <th id="checkboxs">

                                </th>
                                <th>Data</th>
                                <th>Preço</th>
                                <th>Turno</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($pedidos) > 0)
                                @foreach($pedidos as $pedido)
                                    <tr class="even pointer">
                                        <td class="a-center ">

                                        </td>
                                        <td>{{$pedido->data}}</td>
                                        <td>{{$pedido->preco}}</td>
                                        <td>{{$pedido['turno']}}</td>
                                        <td class="iconeListagem"><a {{$pedido->tempoEsgotado ? "disabled data-toggle=popover data-placement=bottom data-trigger=hover" : "href=pedidos/editar/$pedido->id"}} data-content="Tempo para edição esgotado"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                        <td class="iconeListagem"><a {{$pedido->tempoEsgotado ? "disabled data-toggle=popover data-placement=bottom data-trigger=hover" : "class=removerRegistro href=$pedido->id"}} data-content="Tempo para remoção esgotado">
                                                        <i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="iconeListagem">Nenhum pedido encontrado</td>
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
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="adm/js/pedidos.js"></script>

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
                {'bSortable': true,
                    'aTargets': [1],
                    render: $.fn.dataTable.render.moment( 'DD/MM/YYYY' )},
                {'bSortable': false,
                    'aTargets': [4]},
                {'bSortable': false,
                    'aTargets': [5]}
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