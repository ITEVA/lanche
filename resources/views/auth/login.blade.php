@extends('auth.layout.estrutura')

@section('conteudo')
    <div id="login" class="animate form">
        <section class="login_content">
            <img src="adm/images/logo1.png">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form method="post" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <h1>Sistema de gerenciamento</h1>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <input name="email"  type="email" value="{{old('login')}}" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email" required="required" />
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" value="{{old('senha')}}" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Senha" required="required" />
                    <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                </div>

                <div>
                    <a class="reset_pass" href="#toregister">Esqueceu sua senha?</a>
                </div>
                <div>
                    <input type="submit" class="btn btn-default submit" value="Logar" />
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    <div class="clearfix"></div>
                    <br />
                    <div>

                        <p>©2016 ITEVA - Instituto Tecnologico e Vocacional Avançado.</p>
                    </div>
                </div>
            </form>
            <!-- form -->
        </section>
        <!-- content -->
    </div>
    <div id="register" class="animate form">
        <section class="login_content">
            <img src="adm/images/logo1.png">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}
                <h1>Recuperação de senha</h1>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <input  type="text" class="form-control has-feedback-left" name="email" id="inputSuccess4" placeholder="Email" required>
                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                    @endif
                </div>

                <div>
                    <input type="submit" class="btn btn-default submit" value="Enviar" />
                    <a class="reset_pass" href="#tologin">Voltar</a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    <div class="clearfix"></div>
                    <br />
                    <div>
                        <p>©2016 ITEVA - Instituto Tecnologico e Vocacional Avançado.</p>
                    </div>
                </div>
            </form>
            <!-- form -->
        </section>
        <!-- content -->
    </div>
@stop