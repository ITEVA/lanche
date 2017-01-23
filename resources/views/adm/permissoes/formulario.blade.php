@extends('adm.layout.adm')
@section('css')
    <link href="adm/css/permissoes.css" rel="stylesheet">
@endsection
@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cadastro de permissões</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- start form for validation -->
                    <form method="POST" action="{{$action}}" enctype="multipart/form-data" id="demo-form"
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

                        <div class="form-group col-md-5 col-xs-12">
                            <label for="nome">Nome*</label>
                            <input type="text" class="form-control" name="nome"
                                   value="{{old('nome') !== null ? old('nome') : $permissao->nome}}"/>
                        </div>

                        <div class="form-group col-md-5 col-xs-12 quebrarDiv">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" name="descricao">{{old('descricao') !== null ? old('descricao') : $permissao->descricao}}</textarea>
                        </div>

                        <div class="form-group col-md-12 col-xs-12">
                            <label for="descricao">Permissões:</label>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="inicio" name="inicio" {{isset($permissoesAtuais['inicio']) ? 'checked' : ''}}><label class="lblPermissao">Início</label>
                            </span>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="user" name="user" {{isset($permissoesAtuais['user']) ? 'checked' : ''}}><label class="lblPermissao">Usuários</label>
                            </span>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="permissao" name="permissao" {{isset($permissoesAtuais['permissao']) ? 'checked' : ''}}><label class="lblPermissao">Permissões</label>
                            </span>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="produto" name="produto" {{isset($permissoesAtuais['produto']) ? 'checked' : ''}}><label class="lblPermissao">Produtos</label>
                            </span>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="cardapio" name="cardapio" {{isset($permissoesAtuais['cardapio']) ? 'checked' : ''}}><label class="lblPermissao">Cardápio</label>
                            </span>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="perfil" name="perfil" {{isset($permissoesAtuais['perfil']) ? 'checked' : ''}}><label class="lblPermissao">Perfil</label>
                            </span>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="pedido" name="pedido" {{isset($permissoesAtuais['pedido']) ? 'checked' : ''}}><label class="lblPermissao">Pedido</label>
                            </span>
                            <span class="quebraBox">
                                <input type="checkbox" class="permissao" value="relatorio" name="relatorio" {{isset($permissoesAtuais['relatorio']) ? 'checked' : ''}}><label class="lblPermissao">Relatórios</label>
                            </span>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="permissoes">Voltar</a>
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
        $('input.permissao').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    </script>
@endsection