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
                    <h2>Cadastro de usuários</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- start form for validation -->
                    <form method="POST" action="{{$action}}" enctype="multipart/form-data" id="demo-form"
                          data-parsley-validate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        {{ csrf_field() }}
                        <input type="hidden" name="image" id="image"/>
                        <input type="hidden" name="x" id="x"/>
                        <input type="hidden" name="y" id="y"/>
                        <input type="hidden" name="w" id="w"/>
                        <input type="hidden" name="h" id="h"/>
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

                        @if(!isset($ids))
                            <div class="form-group col-md-12 col-xs-12">
                                <img id="imgUsuario" height="100" src="adm/images/perfil/{{$user->foto}}" alt=""/>
                                <input type="file" onchange="ShowImagePreview(this);" name="foto_user"/>
                            </div>
                        @endif

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="nome">Nome*</label>
                            <input type="text" class="form-control" name="nome"
                                   value="{{old('nome') !== null ? old('nome') : $user->nome}}"/>
                        </div>

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="apelido">Apelido*</label>
                            <input type="text" class="form-control" name="apelido"
                                   value="{{old('apelido') !== null ? old('apelido') : $user->apelido}}"/>
                        </div>

                        <div class="form-group col-md-2 col-xs-12">
                            <label>Permissão*</label>
                            <select name="permissao" class="form-control">
                                <option {{(isset($ids) ? 'selected="selected"' : "")}} value="">Selecione uma permissão
                                </option>
                                @if (count($permissoes) > 0)
                                    @foreach ($permissoes as $permissao)
                                        <option {{$permissao->id == old('cargo') || (old('cargo') === null && $permissao->id == $user->permissao) ? 'selected="selected"' : ''}}
                                                value="{{$permissao->id}}">{{$permissao->nome}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="email">Email*</label>
                            <input type="email" class="form-control" name="email" {{isset($ids) ? " disabled" : ""}}
                            value="{{old('email') !== null ? old('email') : $user->email}}"/>
                        </div>

                        <div class="form-group col-md-4 col-xs-12">
                            <label for="password">Senha*</label>
                            <input type="password" class="form-control" name="password" value="{{old('password')}}"/>
                        </div>

                        <div class="form-group col-md-3 col-xs-12">
                            <label>Status</label><br/>
                            @if ((old('status') !== null && old('status') === '0') || (old('status') === null && $user->status == '0'))
                                <input type="radio" class="flat" name="status" value="1"/> Ativo
                                <input type="radio" class="flat" name="status" checked="checked" value="0"/> Inativo
                            @else
                                <input type="radio" class="flat" name="status" checked="checked" value="1"/> Ativo
                                <input type="radio" class="flat" name="status" value="0"/> Inativo
                            @endif
                            @if(isset($ids))
                                <input type="radio" checked="checked" class="flat" name="status" value=""/> NA
                            @endif
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="users">Voltar</a>
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