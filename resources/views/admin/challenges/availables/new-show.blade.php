@extends('adminlte::page')

@section('title', 'Desafios disponiveis')

@section('content_header')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('challenge.availables') }}" class="active">Desafios Diponíveis</a></li>
</ol>

@stop

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Dados Pessoais</h3>
    </div>
    <div class="card-body">

        <div class="form-group">
            <div class="row">
                <div class="col-md-4 ">
                    <label for="nomeMae">Nome da Mãe/Pai:</label>

                    <div>
                        <input type="text" readonly class="form-control" id="nomeMae" value="{{$challenge->client->name}}" placeholder="nomeMae">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nomeBebe">Nome do(a) Bebê:</label>

                    <div>
                        <input type="text" readonly class="form-control" id="nomeBebe" value="{{$challenge->client->nameBaby}}" placeholder="nomeMae">
                    </div>
                </div>
                 <div class="col-md-4">
                    <label for="nomeBebe">Email:</label>

                    <div>
                        <input type="text" readonly class="form-control" id="nomeBebe" value="{{$challenge->client->email}}" placeholder="nomeMae">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 ">
                    <label for="nascimentoBebe">Data de Nascimento do Bebê:</label>

                    <div>
                        <input type="text" readonly class="form-control" id="nascimentoBebe" value="{{\Carbon\Carbon::parse($challenge->client->birthBaby)->format('d/m/Y')}}" placeholder="nomeMae">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="idadeBebe">Idade do Bebê: (DIAS / MESES)</label>

                    <div>
                        <input type="text" readonly class="form-control" id="idadeBebe" value="{{now()->diffInDays(\Carbon\Carbon::parse($challenge->client->birthBaby))}} / {{now()->diffInMonths(\Carbon\Carbon::parse($challenge->client->birthBaby))}}" placeholder="nomeMae">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="sexoBebe">Sexo do Bebê:</label>

                    <div>
                        <input type="text" readonly class="form-control" id="sexoBebe" value="{{$challenge->client->sexBaby == 'M' ? "MASCULINO" : "FEMININO"}}" placeholder="nomeMae">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            @foreach($challenge->analyzes as $analyze)

            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">DIA {{$analyze->day}} - {{\Carbon\Carbon::parse($analyze->date)->format('d/m/Y')}}</h3>

                    </div>

                    <div class="card-body">
                        <h5>Horário que acordou:
                            @if($analyze->timeWokeUp>='06:00:00' && $analyze->timeWokeUp<='08:00:00' ) <span class="badge bg-green">{{$analyze->timeWokeUp}}</span>
                                @else
                                <span class="badge bg-red">{{$analyze->timeWokeUp}}</span>
                                @endif

                        </h5>
                        <h5>Efeito Vulcânico:
                            @if($analyze->volcanicEffect=='N' )
                            <span class="badge bg-green">NÃO</span>
                            @else
                            <span class="badge bg-red">SIM</span>
                            @endif
                            Janela para a Idade <span class="badge bg-green">({{getIdade($challenge->client->birthBaby)}}) DIAS</span>
                            MIN: <span class="badge bg-green">{{getJanela(getIdade($challenge->client->birthBaby))->janelaIdealInicio}}</span> - MAX: <span class="badge bg-green">{{getJanela(now()->diffInDays(\Carbon\Carbon::parse($challenge->client->birthBaby)))->janelaIdealFim}}</span>
                            MAX Sinal de Sono: <span class="badge bg-green">{{getJanela(getIdade($challenge->client->birthBaby))->janelaIdealFim-30}}</span>

                        </h5>


                        <table class="table table-bordered">

                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Sinal de Sono </th>
                                            <th>Horário Dormiu </th>
                                            <th>Horário Acordou</th>
                                            <th>Duração </th>
                                            <th>Janela</th>
                                            <th>Janela Sinal de Sono </th>
                                            <th>  Duração Ritual </th>
                                        </tr>
                                        @foreach ($analyze->naps as $nap)
                                            <tr>
                                                <td>Soneca {{ $nap->number }}</td>
                                                <td> {{ $nap->signalSlept }}</td>
                                                <td> {{ $nap->timeSlept }}</td>
                                                <td> {{ $nap->timeWokeUp }}</td>

                                                <td>
                                                    @if ($nap->duration < 35)
                                                        <span class="badge bg-red">{{ $nap->duration }}</span>
                                                    @endif
                                                    @if ($nap->duration >= 35 && $nap->duration <= 40)
                                                        <span class="badge bg-yellow">{{ $nap->duration }}</span>
                                                    @endif

                                                    @if ($nap->duration > 40)
                                                  
                                                        @if ($nap->duration > 120 &&  now()->diffInDays(\Carbon\Carbon::parse($challenge->client->birthBaby))  > 180)
                                                            <span class="badge bg-orange">{{ $nap->duration }}</span>
                                                        @else
                                                            <span class="badge bg-green">{{ $nap->duration }}</span>
                                                              {{$challenge->client->babyAge}}
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>

                                                    @if ($nap->window >= getJanela(getIdade($challenge->client->birthBaby))->janelaIdealInicio && $nap->window <= getJanela(getIdade($challenge->client->birthBaby))->janelaIdealFim)
                                                        <span class="badge bg-green">{{ $nap->window }}</span>
                                                    @else
                                                        @if ($nap->window < getJanela(getIdade($challenge->client->birthBaby))->janelaIdealInicio)
                                                            <span class="badge bg-yellow">{{ $nap->window }}</span>
                                                        @endif

                                                        @if ($nap->window > getJanela(getIdade($challenge->client->birthBaby))->janelaIdealInicio)
                                                            <span class="badge bg-red">{{ $nap->window }}</span>
                                                        @endif
                                                    @endif



                                                </td>
                                                @php
                                                    
                                                    $var = getJanela(getIdade($challenge->client->birthBaby))->janelaIdealFim;
                                                    
                                                @endphp
                                                <td>
                                                    @if ($var - ($nap->window - $nap->windowSignalSlept) >= 30)
                                                        <span class="badge bg-green">
                                                            {{ $nap->window - $nap->windowSignalSlept }}</span>
                                                    @else
                                                        <span class="badge bg-red">
                                                            {{ $nap->window - $nap->windowSignalSlept }} </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($nap->windowSignalSlept >=35)
                                                    <span class="badge bg-red"> {{ $nap->windowSignalSlept }} </span>
                                                    @endif

                                                     @if($nap->windowSignalSlept < 35 &&  $nap->windowSignalSlept >= 30)
                                                    <span class="badge bg-yellow"> {{ $nap->windowSignalSlept }} </span>
                                                    @endif

                                                      @if($nap->windowSignalSlept < 30)
                                                    <span class="badge bg-green"> {{ $nap->windowSignalSlept }} </span>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Sinal de Sono </th>
                                            <th>Horário Início </th>
                                            <th>Horário Dormiu</th>
                                            <th>Duração </th>
                                            <th>Janela</th>
                                            <th>Janela Sinal de Sono  </th>
                                            <th>  T. Sinal de Sono até Início do Ritual </th>
                                        </tr>
                                        @foreach ($analyze->rituals as $ritual)
                                            <tr>
                                                <td>Ritual</td>
                                                <td> {{ $ritual->signalSlept }}</td>
                                                <td>{{ $ritual->start }}</td>
                                                <td>{{ $ritual->end }}</td>
                                                <td>
                                                    @if ($ritual->duration > 30)
                                                        <span class="badge bg-red">{{ $ritual->duration }}</span>
                                                    @else
                                                        <span class="badge bg-green">{{ $ritual->duration }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ritual->window >= getJanela(getIdade($challenge->client->birthBaby))->janelaIdealInicio && $ritual->window <= getJanela(getIdade($challenge->client->birthBaby))->janelaIdealFim)
                                                        <span class="badge bg-green">{{ $ritual->window }}</span>
                                                    @else
                                                        <span class="badge bg-red">{{ $ritual->window }}</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    @php
                                                        
                                                        $var = getJanela(getIdade($challenge->client->birthBaby))->janelaIdealFim;
                                                        
                                                    @endphp
                                                   
                                                    @if ($var - ($ritual->window - $ritual->windowSignalSlept) >= 30)
                                                        <span class="badge bg-green">
                                                            {{ $ritual->window - $ritual->windowSignalSlept }}</span>
                                                    @else
                                                        <span class="badge bg-red">
                                                            {{ $ritual->window - $ritual->windowSignalSlept }} </span>
                                                    @endif
                                                        </td>
                                                       <td>
                                                   @if($ritual->windowSignalSlept >=35)
                                                    <span class="badge bg-red"> {{ $ritual->windowSignalSlept }} </span>
                                                    @endif

                                                     @if($ritual->windowSignalSlept < 35 &&  $ritual->windowSignalSlept >= 30)
                                                    <span class="badge bg-yellow"> {{ $ritual->windowSignalSlept}} </span>
                                                    @endif

                                                      @if($ritual->windowSignalSlept < 30)
                                                    <span class="badge bg-green"> {{ $ritual->windowSignalSlept }} </span>
                                                    @endif
                                                     

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <table class="table table-bordered">

                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Horário que Acordou </th>
                                            <th>Horário que Dormiu</th>
                                            <th>Duração Acordado</th>
                                            <th>Como dormiu</th>

                                        </tr>
                                        @foreach ($analyze->wakes as $wake)
                                            <tr>
                                                <td>Despertar {{ $wake->number }}</td>
                                                <td> {{ $wake->timeWokeUp }}</td>
                                                <td> {{ $wake->timeSlept }}</td>
                                                <td> {{ $wake->duration }}</td>

                                                <td>
                                                    @if ($wake->sleepingMode == 1)
                                                        Sozinho
                                                    @endif
                                                    @if ($wake->sleepingMode == 2)
                                                        Ninando no berço/cama
                                                    @endif
                                                    @if ($wake->sleepingMode == 3)
                                                        Mamando
                                                    @endif
                                                    @if (is_numeric($wake->sleepingMode) == false)
                                                        {{ $wake->sleepingMode }}
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>



                            </div>



                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Formulário</h3>
    </div>
    <div class="card-body">
<h5>PASSO 2 - FOME:</h5>
<label>Peso Adequado:</label> <span class="badge  {{setStatus($challenge->formulario->fome_peso_adequado)->color}}">{{setStatus($challenge->formulario->fome_peso_adequado)->value}}</span> <br>
<label>Ganho de Peso Adequado:</label> <span class="badge  {{setStatus($challenge->formulario->fome_peso_adequado)->color}}">{{setStatus($challenge->formulario->fome_peso_adequado)->value}}</span> <br>
<label>Urina:</label> <span class="badge  {{setStatus($challenge->formulario->fome_urina)->color}}">{{setStatus($challenge->formulario->fome_urina)->value}}</span> <br>
<label>Evacuações:</label> <span class="badge  {{setStatus($challenge->formulario->fome_evacuacoes)->color}}">{{setStatus($challenge->formulario->fome_evacuacoes)->value}}</span> <br>


<label> Ajustes Fome: </label>
<textarea class="form-control">{{$challenge->formulario->ajustes_fome}}</textarea>

<h5>PASSO 2 -  DOR:</h5>

<label> Ajustes Dor - Geral: </label>
<textarea class="form-control">{{$challenge->formulario->ajustes_dor}}</textarea>
<label> Ajustes Dor -Cólicas: </label>

<textarea class="form-control">{{$challenge->formulario->ajustes_dor_colica}}</textarea>

<label> Ajustes Dor - Refluxo: </label>

<textarea class="form-control">{{$challenge->formulario->ajustes_dor_refluxo}}</textarea>

<label> Ajustes Dor - Dentes: </label>

<textarea class="form-control">{{$challenge->formulario->ajustes_dor_dentes}}</textarea>

<h5>PASSO 2 - Salto de Desenvolvimento:</h5>

<label>Salto ?:</label> <span class="badge  {{setStatus($challenge->formulario->salto)->color}}">{{setStatus($challenge->formulario->salto)->value}}</span> <br>
<label>Marcos:</label> <span class="badge  {{setStatus($challenge->formulario->salto_marcos)->color}}">{{setStatus($challenge->formulario->salto_marcos)->value}}</span> <br>
<label> Ajustes Salto: </label>
<textarea class="form-control">{{$challenge->formulario->ajustes_salto}}</textarea>  
<h5>PASSO 2 - Angustia da Separação:</h5>

<label>Angustia ?:</label> <span class="badge  {{setStatus($challenge->formulario->angustia)->color}}">{{setStatus($challenge->formulario->angustia)->value}}</span> <br>
<label>Chora quando sai do campo de visão:</label> <span class="badge  {{setStatus($challenge->formulario->angustia_campo_visao)->color}}">{{setStatus($challenge->formulario->angustia_campo_visao)->value}}</span> <br>
<label>Chora quando pai atende:</label> <span class="badge  {{setStatus($challenge->formulario->angustia_pai_atende)->color}}">{{setStatus($challenge->formulario->angustia_pai_atende)->value}}</span> <br>
 <label> Ajustes Angustia: </label>
<textarea class="form-control">{{$challenge->formulario->ajustes_angustia}}</textarea>    
<h5>PASSO 2 - Telas:</h5>

<label>Telas ?:</label> <span class="badge  {{setStatus($challenge->formulario->telas)->color}}">{{setStatus($challenge->formulario->telas)->value}}</span> <br>

<label> Ajustes Telas: </label>
<textarea class="form-control">{{$challenge->formulario->ajustes_telas}}</textarea>

    </div>
</div>
    </div>
@stop