@extends('adm.layout.adm')

@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cadastro de produto</h2>

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

                        <div class="form-group col-md-6 col-xs-12">
                            <label for="nome">Nome*</label>
                            <input type="text" class="form-control" name="nome"
                                   value="{{old('nome') !== null ? old('nome') : $produto->nome}}"/>
                        </div>

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="nome">Preço</label>
                            <input type="text" class="form-control money" name="preco"
                                   value="{{old('preco') !== null ? old('preco') : $produto->preco}}"/>
                        </div>

                        <div class="form-group col-md-5 col-xs-12 quebrarDiv">
                            <label for="descricao">Especificação</label>
                            <textarea class="form-control" name="especificacao">{{old('especificacao') !== null ? old('especificacao') : $produto->especificacao}}</textarea>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="produtos">Voltar</a>
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