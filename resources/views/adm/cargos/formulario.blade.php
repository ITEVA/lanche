@extends('adm.layout.adm')
@section('css')
    <link href="adm/css/cargos.css" rel="stylesheet">
@endsection
@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12 divPrincipal colar">
            <div class="x_panel painelConteudo">
                <div class="x_title">
                    <h2 class="titleTamanho">Cadastro de cargo</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content conteudoCargo">
                    <!-- start form for validation -->
                    <form method="POST" env="salvar" action="{{$action}}" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
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

                        <!-- Nome -->
                        <div class="form-group col-md-5 col-xs-12 valuesPadding">
                            <label for="nome">Nome*</label>
                            <input type="text" class="form-control tamanho" name="nome"
                                   value="{{old('nome') !== null ? old('nome') : $cargo->nome}}"/>
                        </div>

                        <!-- Descricao -->
                        <div class="form-group col-md-5 col-xs-12 valuesPadding quebrarDiv">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control tamanho" name="descricao">{{old('descricao') !== null ? old('descricao') : $cargo->descricao}}</textarea>
                        </div>

                        <!-- Valor -->
                        <div class="form-group col-md-5 col-xs-12 valuesPadding quebrarDiv">
                            <label for="valor">Valor*</label>
                            <input type="number" class="form-control tamanho" name="valor" min="0" max="10.0" onkeyup="intervaloValor(this, 0, 10.0)" value="{{old('valor') !== null ? old('valor') : $cargo->valor}}">
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group ladoBTN col-md-12 col-xs-12">
                            <a href="cargos">Voltar</a>
                            <input type="submit" name="formEnv" env="salvar" class="btn btn-success afasta tamanhoBTN" value="Salvar">

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
@stop
@section('js')
    <script>
        $('input.cargo').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    </script>
@endsection