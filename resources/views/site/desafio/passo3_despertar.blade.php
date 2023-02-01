@extends('site.desafio.layouts.app')
@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Passo 3: - Despertar:</h4>
            <textarea class="materialize-textarea">Agora a nossa pré-análise será sobre o Passo 3, mais especificamente, sobre o início da rotina de sono, que é a hora que o bebê acorda.
Aqui vamos avaliar o horário e o seu ritual do bom dia!

E após o preenchimento do seu desafio, você poderá tirar todas as suas dúvidas, dificuldades, particularidades e resultados no seu chat exclusivo. Não se preocupe, que o seu desafio não se resume a uma pré-análise automática!
</textarea>
<iframe width="560" height="315" src="https://www.youtube.com/embed/Z8MkZ7e7a4U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok</a>
        </div>
    </div>

    <div class="row">








        <div class="col s12">
            <div id="input-fields" class="card card-tabs">
                <div class="card-content">
                    <div class="card-title">
                        <div class="row">

                            <div class="col s12 m6 l10">
                                <h4 class="card-title"Meus Dados</h4>
                                    PRÉ-ANÁLISE:

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div id="input-fields" class="card card-tabs">
                @if ($errors->any())
                    <div class="row">
                        <div class="col s12">
                            <div class="card-panel red">
                                <span class="white-text">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>

                @endif
                <div class="card-content">
                    <div class="card-title">
                        <div class="row">

                            <div class="col s12 m6 l10">
                                <h4 class="card-title"Meus Dados</h4>
                                    Dados:

                            </div>
                        </div>
                        <div class="row margin">

                        </div>
                        <div class="row margin">
                            <div class="input-field col s12 m6">

                                <input id="nameBaby" type="text" name="nameBaby"
                                    value="{{ old('nameBaby', $client->nameBaby) }}" class="validate">
                                <label for="nameBaby" class="center-align">Nome do Bebê</label>
                            </div>

                            <div class="input-field col s12 m6">

                                <input id="birthBaby" type="text" name="birthBaby" class="datepicker"
                                    value="{{ now()->diffInDays(\Carbon\Carbon::parse($client->birthBaby)) }} Dias / {{ now()->diffInMonths(\Carbon\Carbon::parse($client->birthBaby)) }} Meses"
                                    required="">
                                <label for="birthBaby" class="center-align">Idade</label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <form action="{{route('analyze.formulario.update', $challenge->id)}}" method="post">
                @csrf
              {{ method_field('PUT') }}
              <input type="hidden" value="FEITO" name="passo3_despertar">
            <div id="input-fields" class="card card-tabs">
                <div class="card-content">
                    <div class="card-title">
                        Despertar
                        <div class="row">

                            @foreach ($challenge->analyzes as $analyze)
                                <div class="col s12 m6">
                                    <div class="card">
                                        <div class="card-content">
                                            <table>
                                                <tr>
                                                    <td>
                                                        Dia: {{ $analyze->day }} -
                                                        {{ \Carbon\Carbon::parse($analyze->date)->format('d/m/Y') }}
                                                    </td>
                                                <tr>
                                                    <td>

                                                        Horário que acordou: </td>
                                                    <td>
                                                        @if ($analyze->timeWokeUp >= '06:00:00' && $analyze->timeWokeUp <= '08:00:00')
                                                            <span class=" badge green">{{ $analyze->timeWokeUp }}</span>
                                                        @else
                                                            <span class=" badge red">{{ $analyze->timeWokeUp }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    Ritual do Bom Dia:
                    <div class="row ">
                        <div class="col s12 ">
                            <h4 class="card-title ">
                                Você faz o ritual do bom dia?
                            </h4>
                            <select class="browser-default" name="rbd" id="rbd">
                                <option value="" disabled selected>Selecione</option>
                                <option value="S">SIM</option>
                                <option value="N">NÃO</option>
                                <option value="N">NÃO SEI</option>
                            </select>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="card">
                        <div class="card-content">
                            Outros:
                            <div class="row ">
                                <div class="col s12 ">
                                    <h4 class="card-title ">
                                       Você deseja comentar sobre o Despertar do seu bebê?
                                    </h4>
                                    


                                        <textarea class="materialize-textarea" name="ritual_bom_dia_outros"></textarea>
                                    
                                    

                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
        <div class="col s12">
             <div class="card">
                 <div class="card-content row">
                    <div class="col s12 m6 l6">
                        <label>Ajustes Horário de Despertar:</label>
                      
                        <textarea class="materialize-textarea" name="conclusao_despertar">{{$orientação_acordou_cedo}}
{{$orientação_acordou_tarde}}
{{$orientação_acordou_bem}}</textarea>
                    </div>
                </div>
                <div class="card-content row">
                    <div class="col s12 m6 l6">
                        <label>Ajustes Ritual do Bom dia:</label>
                        <textarea class="materialize-textarea" id="conclusao_rbd" name="conclusao_rbd"></textarea>
                    </div>
                     <div class="col s12">
            <div class="card">
                        <div class="card-content">
        <button type="submit" class="btn">Enviar</button>
                        </div>
            </div>
         </div>
                </div>
                
            </form>
        </div>
    @endsection
    @section('js')

        <script>
            $(document).ready(function() {
                $('.modal').modal({

                });
                $('#modal1').modal('open');

                $('#rbd').on('change', function() {

                    var opt = $(this).children("option:selected").val();
                    if (opt == 'S') {


                        $('#conclusao_rbd').val('Ótimo! O ritual do bom dia te ajudará a dar ainda mais previsibilidade para o seu bebê! \n Ele vai entender que após o ritual do bom dia, é o horário de sair do ambiente e começar a sua rotina, brincadeiras etc. \nE lembre que um bom ritual do bom dia envolve você só expor o seu bebê às luzes, ruídos, estímulos e tira-lo do ambiente do sono após o ritual. Logo, quando o bebê tiver um despertar noturno, o ideal é que você não o exponha às luzes (apenas o suficiente para suprir a demanda do bebê), aos ruídos e aos estímulos.');
                        M.textareaAutoResize($('#conclusao_rbd'));


                    }
                    if (opt == 'N') {

                        $('#conclusao_rbd').val('O ritual do bom dia te ajudará a dar ainda mais previsibilidade para o seu bebê! 	\n	Ele vai entender que após o ritual do bom dia, é o horário de sair do ambiente e começar a sua rotina, brincadeiras etc. 	\n	E lembre que um bom ritual do bom dia envolve você só expor o seu bebê às luzes, ruídos, estímulos e tira-lo do ambiente do sono após o ritual. Logo, quando o bebê tiver um despertar noturno, o ideal é que você não o exponha às luzes (apenas o suficiente para suprir a demanda do bebê), aos ruídos e aos estímulos.');
                        M.textareaAutoResize($('#conclusao_rbd'));

                    }

                });

            });
        </script>

    @endsection
