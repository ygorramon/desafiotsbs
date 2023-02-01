<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.css') }}" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize-stepper.min.css') }}" media="screen,projection" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @yield('css')
</head>

<body>
  <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
    <div class="brand-sidebar">
      <h1 class="logo-wrapper">
        <a class="brand-logo darken-1" href="index.html">
          
          <span class="logo-text hide-on-med-and-down">Desafio de 7 Dias</span></a><a class="navbar-toggler" href="#"></a></h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
      <li class="bold"><a class="waves-effect waves-cyan " href="{{route('desafio.index')}}"><i class="material-icons">mail_outline</i><span class="menu-title" data-i18n="Mail">Desafios</span></a>
      </li>

       <li class="bold"><a class="waves-effect waves-cyan " href="{{route('doubtCenter.index')}}"><i class="material-icons">help</i><span class="menu-title" data-i18n="Mail">Perguntas Frequentes</span></a>
      </li>
 <li class="bold"><a class="waves-effect waves-cyan " href="{{route('my.queries')}}"><i class="material-icons">help_outline</i><span class="menu-title" data-i18n="Mail">Minhas Perguntas</span></a>
      </li>
      <li class="bold"><a class="waves-effect waves-cyan " href="https://api.whatsapp.com/send?phone=5588996620215" target="_blank "><i class="material-icons">headset_mic</i><span class="menu-title" data-i18n="Mail">Suporte Técnico</span></a>
      </li>
      </li>

      <li class="bold"><a class="waves-effect waves-cyan " href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

          <i class="material-icons">arrow_back</i>
          <span class="menu-title" data-i18n="Chat">Sair</span>
        </a>
      </li>
      <li class="bold">
        <form id="logout-form" action="{{ route('clients.logout') }}" method="POST">
          @csrf
        </form>
      </li>


    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
  </aside>


  <!-- BEGIN: Page Main-->
  <div id="main">


    @yield('content')
    
  </div>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/materialize-stepper.min.js') }}"></script>



  <script>
    $(document).ready(function() {
      $('.sidenav').sidenav();
    });
  </script>
  <script>
    var stepper = document.querySelector('.stepper');
    var stepperInstace = new MStepper(stepper, {
      // options
      firstActive: 0 // this is the default
    })
  </script>


  @yield('js')
</body>

</html>