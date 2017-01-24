@extends('adm.layout.adm')
@section('css')
    <link href="http://edge1y.tapmodo.com/deepliq/global.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v0.9.12/css/jquery.Jcrop.min.css" type="text/css" />
    <link href="http://edge1u.tapmodo.com/deepliq/jcrop_demos.css" rel="stylesheet" type="text/css" />
@endsection
@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Alteração de dados</h2>

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

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email"
                            value="{{old('email') !== null ? old('email') : $usuario->email}}"/>
                        </div>

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="password">Senha*</label>
                            <input type="password" class="form-control" name="password" value="{{old('password')}}"/>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="perfil/{{$usuario->id}}">Voltar</a>
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
    <script src="http://jcrop-cdn.tapmodo.com/v0.9.12/js/jquery.Jcrop.min.js"></script>
    <script src="http://edge1v.tapmodo.com/deepliq/jcrop_demos.js"></script>
    <script src="adm/js/usuario.js"></script>
@endsection