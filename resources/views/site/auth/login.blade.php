@extends('site.auth.layouts.app')
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')


<div class="row">
  <div class="col s12">
    <div class="container">
      <div id="login-page" class="row">

        <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
          <form class="login-form" method="POST" action="{{route('clients.login')}}">
            @csrf
            <div class="row">
              <div class="input-field col s12 center-align mt-10">
                @if (session('message'))
                <div class="row">
                  <div class="col s12">
                    <div class="card-panel red">
                      <span class="white-text">
                        {{session('message')}}</span>
                    </div>
                  </div>
                </div>

                @endif
                <h5>Desafio de 7 Dias</h5>
              </div>

            </div>

            <div class="row margin">
              <div class="input-field col s12">
                <i class="material-icons prefix pt-2">person_outline</i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                <label for="email" class="center-align">E-mail</label>
              </div>
            </div>
            <div class="row margin">
              <div class="input-field col s12">
                <i class="material-icons prefix pt-2">lock_outline</i>
                <input id="password" type="password" name="password">
                <label for="password">Password</label>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m12 l12 ml-2 mt-1">
                <p>
                  <label>
                    <input type="checkbox">
                    <span>Lembrar</span>
                  </label>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <button type="submit" class="btn waves-effect waves-light border-round red col s12">Login</button>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6 m6 l6">
                <p class="margin medium-small"><a href="{{route('clientes.register')}}">Primeiro Acesso</a></p>
              </div>
              <div class="input-field col s6 m6 l6">
                <p class="margin right-align medium-small"><a href="{{route('clientes.reset')}}">Esqueceu a senha?</a></p>
              </div>
            </div>


          </form>
          <div class="card-alert card purple lighten-5">
            <div class="card-content purple-text">
              <a href="https://api.whatsapp.com/send?phone=5588996620215" target="_blank " class="btn"> Dúvidas : Fale Conosco pelo Whatsapp Aqui </a>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

</div>

</div>

</div>

</div>

@endsection