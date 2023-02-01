@extends('site.auth.layouts.app')
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('css/register.css') }}" media="screen,projection" />
@stop
@section('content')
<div class="row">
  <div class="col s12">
    <div class="container">
      <div id="register-page" class="row">
        <div class="col s12 m6  z-depth-4 card-panel border-radius-6 register-card bg-opacity-8">
          <form class="login-form" method="POST" action="{{route('clientes.register')}}">
            @csrf
            <div class="row">
              <div class="input-field col s12">
                <h5 class="ml-4">Primeiro Acesso</h5>
              </div>
              @if ($errors->any())
              <div class="row">
                <div class="col s12">
                  <div class="card-panel red">
                    <span class="white-text">
                      @foreach ($errors->all() as $error)
                      {{ $error }}<br>
                      @endforeach</span>
                  </div>
                </div>
              </div>

              @endif

              @if (session('message'))
              <div class="alert alert-success">
                {{ session('message') }}
              </div>
              @endif

              @if (session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
              @endif

              @if (session('info'))
              <div class="alert alert-warning">
                {{ session('info') }}
              </div>
              @endif
            </div>
            <div class="row margin">
              <div class="input-field col s12">
                <i class="material-icons prefix pt-2">person_outline</i>
                <input id="name" type="text" name="name" class="validate" value="{{ old('name') }}" required="">
                <label for="name" class="center-align">Nome  da Mãe (COM SOBRENOME)</label>
              </div>
            </div>
            <div class="row margin">
              <div class="input-field col s12">
                <i class="material-icons prefix pt-2">person_outline</i>
                <input id="nameBaby" type="text" name="nameBaby" value="{{ old('nameBaby') }}" class="validate" required="">
                <label for="nameBaby" class="center-align">Nome do Bebê</label>
              </div>
            </div>
            <div class="row margin">
              <div class="input-field col s6">
                <i class="material-icons prefix pt-2">person_outline</i>
                <input id="birthBaby" type="text" name="birthBaby" class="datepicker" value="{{ old('birthBaby') }}" required="">
                <label for="birthBaby" class="center-align">Nascimento do Bebê</label>
              </div>

              <div class="col s6">
                <p>Sexo do Bebê</p>
                <p>
                  <label>
                    <input class="validate" required="" name="sexBaby" type="radio" checked="" value="M">
                    <span>Masculino</span>
                  </label>
                </p>

                <label>
                  <input class="validate" required="" name="sexBaby" type="radio" value="F">
                  <span>Feminino</span>
                </label>
                <div class="input-field">
                </div>
              </div>
              <div class="row margin">
                <div class="input-field col s12">
                  <i class="material-icons prefix pt-2">mail_outline</i>
                  <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}"  required="">
                  <label for="email">Email da Hotmart</label>
                </div>
              </div>
              <div class="row margin">
                <div class="input-field col s12">
                  <i class="material-icons prefix pt-2">lock_outline</i>
                  <input id="password" type="password" name="password" class="validate" required="">
                  <label for="password">Password</label>
                </div>
              </div>
              <div class="row margin">
                <div class="input-field col s12">
                  <i class="material-icons prefix pt-2">lock_outline</i>
                  <input id="password-again" type="password" name="password_confirmation" class="validate" required="">
                  <label for="password-again">Password again</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <button type="submit" class="btn waves-effect waves-light border-round  col s12">Cadastrar</button>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <p class="margin medium-small"><a href="{{route('clients.login')}}">Já possue uma conta? Login</a></p>
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
    <div class="content-overlay"></div>
  </div>
</div>

@section('js')
<script>
  $(document).ready(function() {
    $('.datepicker').datepicker({
      firstDay: true,
      format: 'dd/mm/yyyy',
      i18n: {
        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S']
      }
    });
  });
</script>
@stop
@endsection