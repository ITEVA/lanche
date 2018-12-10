@extends('adm.layout.adm')
@section('css')
    <!-- Custom styling plus plugins -->
    <link href="adm/css/custom.css" rel="stylesheet">
    <link href="adm/css/icheck/flat/green.css" rel="stylesheet">
    <link href="adm/css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">

    <link href="adm/css/perfil.css" rel="stylesheet">
@endsection
@section('conteudo')
    <div class="">
        <div class="row conteudoPrincipal">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="col-lg-2">
                        <img src="adm/images/perfil/{{$usuario->foto}}" alt="..." class="img-circle profile_img">
                    </div>

                    <div class="col-lg-10 usuario">
                        <p class="pInxirido">{{$usuario->nome}}</p>
                        <p class="normal">{{$usuario->cargo}}</p>
                    </div>

                    <div class="x_content">
                        <div class="form-group col-md-2 col-xs-12">
                            <input type="hidden" id="idUsuario" value="{{$usuario->id}}">
                            <label>Ano</label>
                            <select id="selectAnos" name="selectAno" class="form-control">
                                @for ($i = 2017; $i <= date("Y"); $i++)
                                    <option {{$i == $anoSelecionado ? 'selected="selected"' : ''}} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <table id="example1" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                            <tr class="headings">
                                <th id="checkboxs">

                                </th>
                                <th>Mês</th>
                                <th>Lanche</th>
                                <th>Almoço</th>
                                <th>Sobremesa</th>
                                <th>Total</th>
                                @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                    <th>Editar</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Janeiro</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJaneiro']['lanche']) ? $usuario['gastosJaneiro']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJaneiro']['almoco']) ? $usuario['gastosJaneiro']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJaneiro']['sobremesa']) ? $usuario['gastosJaneiro']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosJaneiro']['lanche'] + (isset($usuario['gastosJaneiro']['almoco']) ? $usuario['gastosJaneiro']['almoco'] : 0) + (isset($usuario['gastosJaneiro']['sobremesa']) ? $usuario['gastosJaneiro']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/1/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Fevereiro</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosFevereiro']['lanche']) ? $usuario['gastosFevereiro']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosFevereiro']['almoco']) ? $usuario['gastosFevereiro']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosFevereiro']['sobremesa']) ? $usuario['gastosFevereiro']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosFevereiro']['lanche'] + (isset($usuario['gastosFevereiro']['almoco']) ? $usuario['gastosFevereiro']['almoco'] : 0) + (isset($usuario['gastosFevereiro']['sobremesa']) ? $usuario['gastosFevereiro']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/2/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Março</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosMarco']['lanche']) ? $usuario['gastosMarco']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosMarco']['almoco']) ? $usuario['gastosMarco']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosMarco']['sobremesa']) ? $usuario['gastosMarco']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosMarco']['lanche'] + (isset($usuario['gastosMarco']['almoco']) ? $usuario['gastosMarco']['almoco'] : 0) + (isset($usuario['gastosMarco']['sobremesa']) ? $usuario['gastosMarco']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/3/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Abril</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosAbril']['lanche']) ? $usuario['gastosAbril']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosAbril']['almoco']) ? $usuario['gastosAbril']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosAbril']['sobremesa']) ? $usuario['gastosAbril']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosAbril']['lanche'] + (isset($usuario['gastosAbril']['almoco']) ? $usuario['gastosAbril']['almoco'] : 0) + (isset($usuario['gastosAbril']['sobremesa']) ? $usuario['gastosAbril']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/4/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Maio</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosMaio']['lanche']) ? $usuario['gastosMaio']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosMaio']['almoco']) ? $usuario['gastosMaio']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosMaio']['sobremesa']) ? $usuario['gastosMaio']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosMaio']['lanche'] + (isset($usuario['gastosMaio']['almoco']) ? $usuario['gastosMaio']['almoco'] : 0) + (isset($usuario['gastosMaio']['sobremesa']) ? $usuario['gastosMaio']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/5/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Junho</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJunho']['lanche']) ? $usuario['gastosJunho']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJunho']['almoco']) ? $usuario['gastosJunho']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJunho']['sobremesa']) ? $usuario['gastosJunho']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosJunho']['lanche'] + (isset($usuario['gastosJunho']['almoco']) ? $usuario['gastosJunho']['almoco'] : 0) + (isset($usuario['gastosJunho']['sobremesa']) ? $usuario['gastosJunho']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/6/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Julho</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJulho']['lanche']) ? $usuario['gastosJulho']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJulho']['almoco']) ? $usuario['gastosJulho']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosJulho']['sobremesa']) ? $usuario['gastosJulho']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosJulho']['lanche'] + (isset($usuario['gastosJulho']['almoco']) ? $usuario['gastosJulho']['almoco'] : 0) + (isset($usuario['gastosJulho']['sobremesa']) ? $usuario['gastosJulho']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/7/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Agosto</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosAgosto']['lanche']) ? $usuario['gastosAgosto']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosAgosto']['almoco']) ? $usuario['gastosAgosto']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosAgosto']['sobremesa']) ? $usuario['gastosAgosto']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosAgosto']['lanche'] + (isset($usuario['gastosAgosto']['almoco']) ? $usuario['gastosAgosto']['almoco'] : 0) + (isset($usuario['gastosAgosto']['sobremesa']) ? $usuario['gastosAgosto']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/8/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Setembro</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosSetembro']['lanche']) ? $usuario['gastosSetembro']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosSetembro']['almoco']) ? $usuario['gastosSetembro']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosSetembro']['sobremesa']) ? $usuario['gastosSetembro']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosSetembro']['lanche'] + (isset($usuario['gastosSetembro']['almoco']) ? $usuario['gastosSetembro']['almoco'] : 0) + (isset($usuario['gastosSetembro']['sobremesa']) ? $usuario['gastosSetembro']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/9/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Outubro</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosOutubro']['lanche']) ? $usuario['gastosOutubro']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosOutubro']['almoco']) ? $usuario['gastosOutubro']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosOutubro']['sobremesa']) ? $usuario['gastosOutubro']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosOutubro']['lanche'] + (isset($usuario['gastosOutubro']['almoco']) ? $usuario['gastosOutubro']['almoco'] : 0) + (isset($usuario['gastosOutubro']['sobremesa']) ? $usuario['gastosOutubro']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/10/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Novembro</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosNovembro']['lanche']) ? $usuario['gastosNovembro']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosNovembro']['almoco']) ? $usuario['gastosNovembro']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosNovembro']['sobremesa']) ? $usuario['gastosNovembro']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosNovembro']['lanche'] + (isset($usuario['gastosNovembro']['almoco']) ? $usuario['gastosNovembro']['almoco'] : 0) + (isset($usuario['gastosNovembro']['sobremesa']) ? $usuario['gastosNovembro']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/11/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                    </td>
                                    <td>Dezembro</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosDezembro']['lanche']) ? $usuario['gastosDezembro']['lanche'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosDezembro']['almoco']) ? $usuario['gastosDezembro']['almoco'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format(isset($usuario['gastosDezembro']['sobremesa']) ? $usuario['gastosDezembro']['sobremesa'] : '0.0', 2, ',', '.')}}</td>
                                    <td>{{"R$ " . number_format($usuario['gastosDezembro']['lanche'] + (isset($usuario['gastosDezembro']['almoco']) ? $usuario['gastosDezembro']['almoco'] : 0) + (isset($usuario['gastosDezembro']['sobremesa']) ? $usuario['gastosDezembro']['sobremesa'] : 0), 2, ',', '.')}}</td>
                                    @if(array_key_exists('gestaoGastos', $itensPermitidos))
                                        <td class="iconeListagem"><a
                                                    href="gastos/novo/12/{{$anoSelecionado}}/{{$usuario->id}}"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        @if(array_key_exists('gestaoGastos', $itensPermitidos))
                            <div class="form-group col-md-12 col-xs-12">
                                <br><br>
                                <label style="font-size: 19pt;">Listagem de todos os usários</label>
                            </div>
                            <table id="example" class="table table-striped responsive-utilities jambo_table">
                                <thead>
                                <tr class="headings">
                                    <th id="checkboxs">

                                    </th>
                                    <th>Nome</th>
                                    <th>Gasto mês atual</th>
                                    <th>Detalhe</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($usuarios) > 0)
                                    @foreach($usuarios as $u)
                                        <tr class="even pointer">
                                            <td class="a-center "></td>
                                            <td>{{$u->apelido}}</td>
                                            <td>{{"R$ " . number_format($u->consumo, 2, ',', '.')}}</td>
                                            <td class="iconeListagem"><a
                                                        href="gastos/{{$u->id}}/{{$anoSelecionado}}"><i
                                                            class="fa fa-search"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="iconeListagem">Nenhuma permissão encontrada</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        @endif
                        <form id="formSelecionados" method="post" action="">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                            <input type="hidden" name="ids" id="ids" value=""/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="adm/js/perfil.js"></script>
    <script src="adm/js/gastos.js"></script>

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
            //"bPaginate": false,
            "order": [[0, "asc"]],
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
                    'aTargets': [1]},
                {'bSortable': false,
                    'aTargets': [2]},
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