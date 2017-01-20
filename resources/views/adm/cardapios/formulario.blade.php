@extends('adm.layout.adm')

@section('css')
    <!-- select2 -->
    <link href="adm/css/select/select2.min.css" rel="stylesheet">
@endsection

@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cadastro de Lanche</h2>

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

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="data">Data</label>
                            <input type="text" class="form-control date-picker" name="data"
                                   value="{{old('data') !== null ? old('data') : $cardapio->data}}"/>
                        </div>

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="hora_inicio">Hora Início</label>
                            <input type="time" class="form-control" name="hora_inicio"
                                   value="{{old('hora_inicio') !== null ? old('hora_inicio') : $cardapio->hora_inicio}}"/>
                        </div>

                        <div class="form-group col-md-3 col-xs-12">
                            <label for="hora_final">Hora Final</label>
                            <input type="time" class="form-control" name="hora_final"
                                   value="{{old('hora_final') !== null ? old('hora_final') : $cardapio->hora_final}}"/>
                        </div>

                        <div class="form-group col-md-1 col-xs-12">
                            <label>Turno</label><br/>
                            @if ((old('turno') !== null && old('turno') === '0') || (old('turno') === null && $cardapio->turno == '0'))
                                <input type="radio" class="flat" name="turno" value="1"/> Manhã
                                <input type="radio" class="flat" name="turno" checked="checked" value="0"/> Tarde
                            @else
                                <input type="radio" class="flat" name="turno" checked="checked" value="1"/> Manhã
                                <input type="radio" class="flat" name="turno" value="0"/> Tarde
                            @endif
                            @if(isset($ids))
                                <input type="radio" checked="checked" class="flat" name="turno" value=""/> NA
                            @endif
                        </div>

                        <div class="form-group col-md-3 col-xs-12 quebrarDiv">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Produtos</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" name="produtos[]">
                                    @if (count($produtos) > 0)
                                        @foreach ($produtos as $produto)
                                            @if(isset($produtosAtuais))
                                                {{$ctrl = 0}}
                                                @for($i = 0; $i < count($produtosAtuais); $i++)
                                                    @if($produto->id == $produtosAtuais[$i]->id_produto)
                                                        <option selected="selected" value="{{$produto->id}}">{{$produto->nome}}</option>
                                                        {{$i = count($produtosAtuais)}}
                                                        {{$ctrl = 1}}
                                                    @endif
                                                @endfor
                                                @if(!$ctrl)
                                                    <option value="{{$produto->id}}">{{$produto->nome}}</option>
                                                @endif
                                            @else
                                                <option value="{{$produto->id}}">{{$produto->nome}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="cardapios">Voltar</a>
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
    <!-- select2 -->
    <script src="adm/js/select/select2.full.js"></script>
    <!-- form validation -->
    <!-- select2 -->
    <script>
        $(document).ready(function() {
            $(".select2_single").select2({
                placeholder: "Select a state",
                allowClear: true
            });
            $(".select2_group").select2({});
            $(".select2_multiple").select2({
                maximumSelectionLength: 1000,
                placeholder: "Selecione os produtos do dia",
                allowClear: true
            });
        });
    </script>
    <!-- /select2 -->
@endsection