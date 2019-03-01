@extends('adm.layout.adm')
@section('css')
    <link href="adm/css/permissoes.css" rel="stylesheet">
@endsection
@section('conteudo')
    <div class="cssload-loading">
        <i></i>
        <i></i>
        <i></i>
    </div>
    <div class="block"></div>
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cadastro de almoço</h2>
                    <div class="pull-right"><button class="btn btn-success" id="btnVisitante">Visitante</button></div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- start form for validation -->
                    <form class="forms" method="POST" action="{{$action}}" enctype="multipart/form-data" id="demo-form"
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

                        <div class="col-md-12 col-xs-12">
                            <div id="divVisitantes"></div>
                            @foreach($usuarios as $usuario)
                                <div class="form-group col-md-12 col-xs-12" style="height: 45px">
                                    <div class="form-group col-md-2 col-xs-12">
                                        <?php
                                            $padrao = true;
                                            if(isset($usuario->visitante)){
                                                if($usuario->visitante == 1){
                                                    $apelido = 'Visitante';
                                                    $imagem = 'default.png';
                                                    $padrao = false;
                                                }
                                            }
                                            if($padrao){
                                                $apelido = isset($usuario->peso) ? $usuario->usuario->apelido : $usuario->apelido;
                                                $imagem = isset($usuario->peso) ? $usuario->usuario->foto : $usuario->foto;
                                            }
                                        ?>
                                        <img style="width: 70px; border-radius: 15px;" src="adm/images/perfil/{{$imagem}}" alt=""/>
                                        <label for="titulo">{{$apelido}}</label>
                                        <input type="hidden" name="id_usuario[]" value="{{isset($usuario->peso) ? $usuario->usuario->id : $usuario->id}}">
                                        <input type="hidden" name="visitante[]" value="{{isset($usuario->visitante) ? $usuario->visitante:0}}">
                                    </div>

                                    <div class="form-group col-md-2 col-xs-12">
                                        <label for="titulo">Peso</label>
                                        <div class="form-group col-md-12 col-xs-12">
                                            <input type="text" name="peso[]" class="tags form-control tags_1" value="{{isset($usuario->peso) ? $usuario->peso : ''}}"/>
                                            <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-2 col-xs-12">
                                        <label for="titulo">Sobremesa</label>
                                        <select name="id_sobremesa[]" class="select2_single form-control">
                                            <option selected="selected" value="">Selecione uma sobremesa</option>
                                            @if (count($sobremesas) > 0)
                                                @foreach ($sobremesas as $sobremesa)
                                                    <option {{(isset($usuario->peso) && $usuario->sobremesa == $sobremesa->produto->id) ? 'selected="selected"' : ''}} value="{{$sobremesa->produto->id}}">{{$sobremesa->produto->nome}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3 col-xs-12">
                                        <input type="submit" name="salvar" value="Salvar" style="margin-top: 24px" class="btn btn-success blockSave">
                                    </div>
                                </div>

                                <div class="ln_solid col-md-12 col-xs-12"></div>
                            @endforeach
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success blockSave">
                            <a href="almocos">Voltar</a>
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
    <div id="baseDivVisitantes" style="display: none">
        <div class="form-group col-md-12 col-xs-12" style="height: 45px">
            <div class="form-group col-md-2 col-xs-12">
                <img style="width: 70px; border-radius: 15px;" src="adm/images/perfil/default.png" alt=""/>
                <label for="titulo">Visitante</label>
                <input type="hidden" name="id_usuario[]" value="{{$contaIteva}}">
                <input type="hidden" name="visitante[]" value="1">
            </div>

            <div class="form-group col-md-2 col-xs-12">
                <label for="titulo">Peso</label>
                <div class="form-group col-md-12 col-xs-12">
                    <input type="number" name="peso[]" class="tags form-control peso" id="" value=""/>
                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                </div>
            </div>

            <div class="form-group col-md-2 col-xs-12">
                <label for="titulo">Sobremesa</label>
                <select name="id_sobremesa[]" class="select2_single form-control">
                    <option selected="selected" value="">Selecione uma sobremesa</option>
                    @if (count($sobremesas) > 0)
                        @foreach ($sobremesas as $sobremesa)
                            <option value="{{$sobremesa->produto->id}}">{{$sobremesa->produto->nome}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group col-md-3 col-xs-12">
                <input type="submit" name="salvar" value="Salvar" style="margin-top: 24px" class="btn btn-success blockSave">
            </div>
        </div>
        <div class="ln_solid col-md-12 col-xs-12"></div>
    </div>
@stop
@section('js')
    <script>
        $('input.permissao').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    </script>

    <!-- tags -->
    <script src="adm/js/tags/jquery.tagsinput.min.js"></script>

    <!-- input tags -->
    <script>
        $(window).scroll(_=>scroll());
        $(document).ready(_=>scroll());

        function scroll(){
            valor_atual = $(document).scrollTop();
            if (valor_atual >= 50){
                $('#btnVisitante').css('position','fixed');
                $('#btnVisitante').css('top','20px');
                $('#btnVisitante').css('right','36px');
            }
            if (valor_atual < 50){
                $('#btnVisitante').css('position','absolute');
                $('#btnVisitante').css('top','7px');
                $('#btnVisitante').css('right','15px');
            }
        }
        var count = 1;
        $('#btnVisitante').click(function () {
            var id = 'input'+count;
            $('#baseDivVisitantes .peso').attr('id',id);
            var base = $('#baseDivVisitantes').html();
            $('#divVisitantes').append(base);
            initag('#'+id);
            $('#'+id+'_tag').focus();
            count++;
        });

        function onAddTag(tag) {
            alert("Added a tag: " + tag);
        }

        function onRemoveTag(tag) {
            alert("Removed a tag: " + tag);
        }

        function onChangeTag(input, tag) {
            alert("Changed a tag: " + tag);
        }

        initag('.tags_1');
        function initag(ident) {
            $(ident).tagsInput({
                trimValue: true,
                width: 'auto'
            });
            return null
        }

    </script>
    <!-- /input tags -->
@endsection