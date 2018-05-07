@extends('adm.layout.adm')
@section('css')
@endsection
@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cadastro de almoço e sobremesa</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- start form for validation -->
                    <form method="POST" action="{{$action}}" enctype="multipart/form-data" id="demo-form"
                          data-parsley-validate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        {{ csrf_field() }}

                        @if (count($errors) > 0)
                            <ul style="color: red;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <input type="hidden" name="mes" value="{{$mes}}">
                        <input type="hidden" name="ano" value="{{$ano}}">
                        <input type="hidden" name="id_usuario" value="{{$idUsuario}}">
                        <input type="hidden" name="gasto" value="{{isset($gastos) ? $gastos->id : ''}}">

                        <div class="form-group col-md-12 col-xs-12">
                            <label for="almoco">Mês/Ano: {{$mes}} / {{$ano}}</label>
                        </div>

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="almoco">Almoço</label>
                            <input type="text" class="form-control money" name="almoco"
                                value="{{old('almoco') !== null ? old('almoco') : (isset($gastos) ? $gastos->almoco : '')}}"/>
                        </div>

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="sobremesa">Sobremesa</label>
                            <input type="text" class="form-control money" name="sobremesa"
                                   value="{{old('sobremesa') !== null ? old('sobremesa') : (isset($gastos) ? $gastos->sobremesa : '')}}"/>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="gastos/{{$idUsuario}}">Voltar</a>
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

@endsection