@extends('site.desafio.layouts.app')
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')




<div class="row">
    <div class="col s12">
    <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>PASSO 1 - VÍDEO EXPLICATIVO</h4>
      <div class="video-container">
      <iframe height="250"  src="https://www.youtube.com/embed/heyGFKnpYP0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
  
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
  </div>

        <div class="card">
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
            <div class="card-content pb-0">
                <div class="card-header mb-2">

                    <h4 class="card-title">Dia {{$day}}</h4>
                </div>
                <form action="{{route('analyze.store',[$challenge->id, $day])}}" method="POST">
                    @csrf
                    <ul class="stepper horizontal" id="horizStepper">
                        <li class="step active">
                            <div class="step-title waves-effect">Informações</div>
                            <div class="step-content">
                                <div class="row">
                                    <div class="input-field col m6 s12">

                                        <input type="text" id="date" name="date" value="{{ old('date') }}" class="datepicker">
                                        <label for="date">Data da Avaliação</label>

                                    </div>
                                    <div class="input-field col m6 s12">
                                        <input id="timeWokeUp" type="text" name="timeWokeUp" value="{{ old('timeWokeUp') }}" class="timepicker">
                                        <label for="timeWokeUp">Horário que Acordou</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col m6 s12">
                                        <div class="switch">
                                            <label>
                                                Efeito Vulcânico?: Não
                                                <input type="checkbox" name="volcanicEffect" value="S" @if(old('volcanicEffect')=="S" ) checked @endif>
                                                <span class="lever"></span>
                                                Sim
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="step-actions">
                                    <div class="row">
                                        <div class="col m4 s12 mb-4">
                                            <button class="red btn btn-reset" type="reset">
                                                Reset
                                                <i class="material-icons left">clear</i>

                                            </button>
                                        </div>
                                        <div class="col m4 s12 mb-4">
                                            <button class="btn btn-light previous-step" disabled>
                                                <i class="material-icons left">arrow_back</i>
                                                Prev
                                            </button>
                                        </div>
                                        <div class="col m4 s12 mb-4">
                                            <button class="waves-effect waves dark btn btn-primary next-step" type="submit">
                                                Next
                                                <i class="material-icons right">arrow_forward</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="step">
                            <div class="step-title waves-effect">Rotina de Sonecas</div>
                            <div class="step-content">
                                <div class="row">
                                    <div class="card card card-default scrollspy">

                                        <div class="card-content">
                                            <h5>Soneca 1</h5>
                                            <div class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca1_ss" value="{{ old('soneca1_ss') }}" class="timepicker">
                                                    <label for="soneca1_ss">Horário que sentiu sono</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="soneca1_hd" name="soneca1_hd" value="{{ old('soneca1_hd') }}" class="timepicker">
                                                    <label for="soneca1_hd">Horário que dormiu</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca1_ha" value="{{ old('soneca1_ha') }}" class="timepicker">
                                                    <label for="soneca1_ha">Horário que acordou</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Soneca 2</h5>
                                            <div class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca2_ss" value="{{ old('soneca2_ss') }}" class="timepicker">
                                                    <label for="soneca2_ss">Horário que sentiu sono</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="soneca1_hd" name="soneca2_hd" value="{{ old('soneca2_hd') }}" class="timepicker">
                                                    <label for="soneca2_hd">Horário que dormiu</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca2_ha" value="{{ old('soneca2_ha') }}" class="timepicker">
                                                    <label for="soneca2_ha">Horário que acordou</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Soneca 3</h5>
                                            <div class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca3_ss" value="{{ old('soneca3_ss') }}" class="timepicker">
                                                    <label for="soneca3_ss">Horário que sentiu sono</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="soneca1_hd" name="soneca3_hd" value="{{ old('soneca3_hd') }}" class="timepicker">
                                                    <label for="soneca3_hd">Horário que dormiu</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca3_ha" value="{{ old('soneca3_ha') }}" class="timepicker">
                                                    <label for="soneca3_ha">Horário que acordou</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Soneca 4</h5>
                                            <div class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca4_ss" value="{{ old('soneca4_ss') }}" class="timepicker">
                                                    <label for="soneca4_ss">Horário que sentiu sono</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="soneca1_hd" name="soneca4_hd" value="{{ old('soneca4_hd') }}" class="timepicker">
                                                    <label for="soneca4_hd">Horário que dormiu</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca4_ha" value="{{ old('soneca4_ha') }}" class="timepicker">
                                                    <label for="soneca4_ha">Horário que acordou</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Soneca 5</h5>
                                            <div class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca5_ss" value="{{ old('soneca5_ss') }}" class="timepicker">
                                                    <label for="soneca5_ss">Horário que sentiu sono</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="soneca1_hd" name="soneca5_hd" value="{{ old('soneca5_hd') }}" class="timepicker">
                                                    <label for="soneca5_hd">Horário que dormiu</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca5_ha" value="{{ old('soneca5_ha') }}" class="timepicker">
                                                    <label for="soneca5_ha">Horário que acordou</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Soneca 6</h5>
                                            <div class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca6_ss" value="{{ old('soneca6_ss') }}" class="timepicker">
                                                    <label for="soneca6_ss">Horário que sentiu sono</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="soneca1_hd" name="soneca6_hd" value="{{ old('soneca6_hd') }}"  class="timepicker">
                                                    <label for="soneca6_hd">Horário que dormiu</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="soneca6_ha" value="{{ old('soneca6_ha') }}" class="timepicker">
                                                    <label for="soneca6_ha">Horário que acordou</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="step-actions" style="position:relative">
                                        <div class="row">
                                            <div class="col m4 s12 mb-3">
                                                <button class="red btn btn-reset" type="reset">
                                                    <i class="material-icons left">clear</i>Reset
                                                </button>
                                            </div>
                                            <div class="col m4 s12 mb-3">
                                                <button class="btn btn-light previous-step">
                                                    <i class="material-icons left">arrow_back</i>
                                                    Prev
                                                </button>
                                            </div>
                                            <div class="col m4 s12 mb-3">
                                                <button class="waves-effect waves dark btn btn-primary next-step" type="submit">
                                                    Next
                                                    <i class="material-icons right">arrow_forward</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="step">
                            <div class="step-title waves-effect">Ritual Noturno</div>
                            <div class="step-content">
                                <div class="row">
                                    <div class="card card card-default scrollspy">

                                        <div class="card-content">
                                            <h5>Ritual</h5>
                                            <div class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="ritual_ss" name="ritual_ss" value="{{ old('ritual_ss') }}" class="timepicker">
                                                    <label for="ritual_ss">Horário que sentiu sono</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="time" name="ritual_in" value="{{ old('ritual_in') }}" class="timepicker">
                                                    <label for="ritual_in">Horário que iniciou</label>

                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" id="ritual_d" name="ritual_d" value="{{ old('ritual_d') }}" class="timepicker">
                                                    <label for="ritual_d">Horário que dormiu</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Despertar 1</h5>
                                            <div class="row">
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar1_a" name="despertar1_a" value="{{ old('despertar1_a') }}" class="timepicker">
                                                    <label for="despertar1_a">Horário que acordou</label>

                                                </div>
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar1_d" name="despertar1_d" value="{{ old('despertar1_d') }}" class="timepicker">
                                                    <label for="despertar1_d">Horário que dormiu</label>

                                                </div>
                                                <div class="col m3 s12">
                                                <label>Como dormiu</label>
                                                <br>
                                                    <select class="browser-default" name="despertar1_fd" id="despertar1_fd">
                                                        <option  value="" disabled selected>Selecione uma opção</option>
                                                        <option {{ old('despertar1_fd')==1 ? "selected" : "" }} value="1">Sozinho</option>
                                                        <option {{ old('despertar1_fd')==2 ? "selected" : "" }} value="2">Ninando no berço/cama</option>
                                                        <option {{ old('despertar1_fd')==3 ? "selected" : "" }} value="3">Mamando</option>
                                                        <option {{ is_numeric(old('despertar1_fd')==false) ? "selected" : "" }} value="4">Outro</option>
                                                    </select>
                                                    
                                                </div>
                                                <div class="input-field col m3 s12" id="despertar1_fd_outro">
                                                    <input  type="text" id="despertar1_fd_outro"" name=" despertar1_fd_outro" value="{{ old('despertar1_fd_outro') }}">
                                                    <label for="despertar1_fd_outro">Como Dormiu</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Despertar 2</h5>
                                            <div class="row">
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar2_a" name="despertar2_a"  value="{{ old('despertar2_a') }}" class="timepicker">
                                                    <label for="despertar2_a">Horário que acordou</label>

                                                </div>
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar2_d" name="despertar2_d" value="{{ old('despertar2_d') }}" class="timepicker">
                                                    <label for="despertar2_d">Horário que dormiu</label>

                                                </div>
                                                <div class="col m3 s12">
                                                <label>Como dormiu</label>
                                                    <select class="browser-default" name="despertar2_fd" id="despertar2_fd">
                                                        <option  value="" disabled selected>Selecione uma opção</option>
                                                        <option {{ old('despertar2_fd')==1 ? "selected" : "" }} value="1">Sozinho</option>
                                                        <option {{ old('despertar2_fd')==2 ? "selected" : "" }} value="2">Ninando no berço/cama</option>
                                                        <option {{ old('despertar2_fd')==3 ? "selected" : "" }} value="3">Mamando</option>
                                                        <option {{ is_numeric(old('despertar2_fd')==false) ? "selected" : "" }} value="4">Outro</option>
                                                    </select>

                                                </div>
                                                <div class="input-field col m3 s12" id="despertar2_fd_outro">
                                                    <input type="text" id="despertar2_fd_outro"" value="{{ old('despertar2_fd_outro') }}" name=" despertar2_fd_outro">
                                                    <label for="despertar2_fd_outro">Como Dormiu</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Despertar 3</h5>
                                            <div class="row">
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar3_a" name="despertar3_a" value="{{ old('despertar3_a') }}"  class="timepicker">
                                                    <label for="despertar3_a">Horário que acordou</label>

                                                </div>
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar3_d" name="despertar3_d" value="{{ old('despertar3_d') }}" class="timepicker">
                                                    <label for="despertar3_d">Horário que dormiu</label>

                                                </div>

                                                <div class="col m3 s12">
                                                <label>Como dormiu</label>
                                                    <select class="browser-default" name="despertar3_fd" id="despertar3_fd">
                                                        <option value="" disabled selected>Selecione uma opção</option>
                                                        <option {{ old('despertar3_fd')==1 ? "selected" : "" }} value="1">Sozinho</option>
                                                        <option {{ old('despertar3_fd')==2 ? "selected" : "" }} value="2">Ninando no berço/cama</option>
                                                        <option {{ old('despertar3_fd')==3 ? "selected" : "" }} value="3">Mamando</option>
                                                        <option {{ is_numeric(old('despertar3_fd')==false) ? "selected" : "" }} value="4">Outro</option>
                                                    </select>

                                                </div>
                                                <div class="input-field col m3 s12" id="despertar3_fd_outro">
                                                    <input  type="text" id="despertar3_fd_outro"" name=" despertar3_fd_outro" value="{{ old('despertar3_fd_outro') }}">
                                                    <label for="despertar3_fd_outro">Como Dormiu</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Despertar 4</h5>
                                            <div class="row">
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar4_a" name="despertar4_a" value="{{ old('despertar4_a') }}" class="timepicker">
                                                    <label for="despertar4_a">Horário que acordou</label>

                                                </div>
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar4_d" name="despertar4_d" value="{{ old('despertar4_d') }}" class="timepicker">
                                                    <label for="despertar4_d">Horário que dormiu</label>

                                                </div>
                                                <div class="col m3 s12">
                                                <label>Como dormiu</label>                                                    <select class="browser-default" name="despertar4_fd" id="despertar4_fd">
                                                        <option value="" disabled selected>Selecione uma opção</option>
                                                        <option {{ old('despertar4_fd')==1 ? "selected" : "" }} value="1">Sozinho</option>
                                                        <option {{ old('despertar4_fd')==2 ? "selected" : "" }} value="2">Ninando no berço/cama</option>
                                                        <option {{ old('despertar4_fd')==3 ? "selected" : "" }} value="3">Mamando</option>
                                                        <option {{is_numeric(old('despertar4_fd')==false) ? "selected" : "" }} value="4">Outro</option>
                                                    </select>

                                                </div>
                                                <div class="input-field col m3 s12" id="despertar4_fd_outro">
                                                    <input type="text" id="despertar4_fd_outro"" name=" despertar4_fd_outro" value="{{ old('despertar4_fd_outro') }}">
                                                    <label for="despertar4_fd_outro">Como Dormiu</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Despertar 5</h5>
                                            <div class="row">
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar5_a" name="despertar5_a" value="{{ old('despertar5_a') }}" class="timepicker">
                                                    <label for="despertar5_a">Horário que acordou</label>

                                                </div>
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar5_d" name="despertar5_d" value="{{ old('despertar5_d') }}" class="timepicker">
                                                    <label for="despertar5_d">Horário que dormiu</label>

                                                </div>
                                                <div class="col m3 s12">
                                                <label>Como dormiu</label>                                                    <select class="browser-default" name="despertar5_fd" id="despertar5_fd">
                                                        <option value="" disabled selected>Selecione uma opção</option>
                                                        <option {{ old('despertar5_fd')==1 ? "selected" : "" }} value="1">Sozinho</option>
                                                        <option {{ old('despertar5_fd')==2 ? "selected" : "" }} value="2">Ninando no berço/cama</option>
                                                        <option {{ old('despertar5_fd')==3 ? "selected" : "" }} value="3">Mamando</option>
                                                        <option {{ is_numeric(old('despertar5_fd')==false) ? "selected" : "" }}value="4">Outro</option>
                                                    </select>

                                                </div>
                                                <div class="input-field col m3 s12" id="despertar5_fd_outro">
                                                    <input  type="text" id="despertar5_fd_outro"" name=" despertar5_fd_outro" value="{{ old('despertar5_fd_outro') }}">
                                                    <label for="despertar5_fd_outro">Como Dormiu</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="card card card-default ">

                                        <div class="card-content">
                                            <h5>Despertar 6</h5>
                                            <div class="row">
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar6_a" name="despertar6_a" value="{{ old('despertar6_a') }}" class="timepicker">
                                                    <label for="despertar6_a">Horário que acordou</label>

                                                </div>
                                                <div class="input-field col m3 s12">
                                                    <input type="text" id="despertar6_d" name="despertar6_d" value="{{ old('despertar6_d') }}" class="timepicker">
                                                    <label for="despertar6_d">Horário que dormiu</label>

                                                </div>

                                                <div class="col m3 s12">
                                                <label>Como dormiu</label>                                                    <select class="browser-default" name="despertar6_fd" id="despertar6_fd">
                                                        <option value="" disabled selected>Selecione uma opção</option>
                                                        <option {{ old('despertar6_fd')==1 ? "selected" : "" }} value="1">Sozinho</option>
                                                        <option {{ old('despertar6_fd')==2 ? "selected" : "" }} value="2">Ninando no berço/cama</option>
                                                        <option {{ old('despertar6_fd')==3 ? "selected" : "" }} value="3">Mamando</option>
                                                        <option {{ is_numeric(old('despertar6_fd')==false) ? "selected" : "" }} value="4">Outro</option>
                                                    </select>

                                                </div>
                                                <div class="input-field col m3 s12" id="despertar6_fd_outro">
                                                    <input  type="text" id="despertar6_fd_outro"" name=" despertar6_fd_outro" value="{{ old('despertar6_fd_outro') }}">
                                                    <label for="despertar6_fd_outro">Como Dormiu</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="step-actions" style="position:relative">
                                        <div class="row">
                                            <div class="col m4 s12 mb-3">
                                                <button class="red btn btn-reset" type="reset">
                                                    <i class="material-icons left">clear</i>Reset
                                                </button>
                                            </div>
                                            <div class="col m4 s12 mb-3">
                                                <button class="btn btn-light previous-step">
                                                    <i class="material-icons left">arrow_back</i>
                                                    Prev
                                                </button>
                                            </div>
                                            <div class="col m4 s12 mb-3">
                                                <button class="waves-effect waves dark btn btn-primary " type="submit">
                                                    Enviar
                                                    <i class="material-icons right">arrow_forward</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                </form>
                </ul>

            </div>
        </div>
    </div>


    @endsection

    @section('js')
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy'
            });
            $('.timepicker').timepicker({
                twelveHour: false
            });

            $("select").formSelect();
        });

        $('#despertar1_fd_outro').hide();

        $('#despertar1_fd').change(function() {
            if ($(this).val() === '4') {
                $('#despertar1_fd_outro').show();
            }
            if ($(this).val() != '4') {
                $('#despertar1_fd_outro').hide();
            }
        });
        $('#despertar2_fd_outro').hide();

        $('#despertar2_fd').change(function() {
            if ($(this).val() === '4') {
                $('#despertar2_fd_outro').show();
            }
            if ($(this).val() != '4') {
                $('#despertar2_fd_outro').hide();
            }
        });
        $('#despertar3_fd_outro').hide();

        $('#despertar3_fd').change(function() {
            if ($(this).val() === '4') {
                $('#despertar3_fd_outro').show();
            }
            if ($(this).val() != '4') {
                $('#despertar3_fd_outro').hide();
            }
        });
        $('#despertar4_fd_outro').hide();

        $('#despertar4_fd').change(function() {
            if ($(this).val() === '4') {
                $('#despertar4_fd_outro').show();
            }
            if ($(this).val() != '4') {
                $('#despertar4_fd_outro').hide();
            }
        });
        $('#despertar5_fd_outro').hide();

        $('#despertar5_fd').change(function() {
            if ($(this).val() === '4') {
                $('#despertar5_fd_outro').show();
            }
            if ($(this).val() != '4') {
                $('#despertar5_fd_outro').hide();
            }
        });

        $('#despertar6_fd_outro').hide();

        $('#despertar6_fd').change(function() {
            if ($(this).val() === '4') {
                $('#despertar6_fd_outro').show();
            }
            if ($(this).val() != '4') {
                $('#despertar6_fd_outro').hide();
            }
        });
    </script>



<script>
$(document).ready(function(){
    $('.modal').modal({
       
    });
    $('#modal1').modal('open');
  });
  </script>


    @endsection