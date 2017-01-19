@extends('auth.layout.estrutura')

@section('conteudo')
    <div id="login" class="animate form">
        <section class="login_content">
            <img src="adm/images/logo1.png">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}
                <h1>Redefinição de senha</h1>
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <input name="email"  type="email" value="{{old('email')}}" class="form-control has-feedback-left" id="email" placeholder="Email" required="required" />
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                    <input name="password" type="password" value="{{old('password')}}" class="form-control has-feedback-left" id="password" placeholder="Senha" required="required" />
                    <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
                    <input name="password_confirmation" type="password" value="{{old('password-confirm')}}" class="form-control has-feedback-left" id="password-confirm" placeholder="Corfime a senha" required="required" />
                    <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                    @endif
                </div>

                <div>
                    <input type="submit" class="btn btn-default submit" value="Redefinir" />
                    <a class="reset_pass" href="login#tologin">Voltar</a>
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