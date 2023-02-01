@extends('site.desafio.layouts.app')
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4>PASSO 2 - Causa dos Despertares</h4>

        <textarea class="materialize-textarea">Agora vamos analisar o Passo 2, que é entender por que o seu bebê está acordando e aqui vamos fazer uma revisão detalhada de cada uma das principais causas:

E após o preenchimento do seu desafio, você poderá tirar todas as suas dúvidas, dificuldades, particularidades e resultados no seu chat exclusivo. Não se preocupe, que o seu desafio não se resume a uma pré-análise automática!
</textarea>
<div class="video-container">
<iframe width="560" height="315" src="https://www.youtube.com/embed/Z7hVH-ElzdE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>      </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok</a>
    </div>
</div>

<div class="row">

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
                            <h4 class="card-title" Meus Dados</h4>
                                Dados:

                        </div>
                    </div>
                    <div class="row margin">

                    </div>
                    <div class="row margin">
                        <div class="input-field col s12 m6">

                            <input id="nameBaby" type="text" name="nameBaby" value="{{ old('nameBaby', $client->nameBaby) }}" class="validate">
                            <label for="nameBaby" class="center-align">Nome do Bebê</label>
                        </div>

                        <div class="input-field col s12 m6">

                            <input id="birthBaby" type="text" name="birthBaby" class="datepicker" value="{{ now()->diffInDays(\Carbon\Carbon::parse($client->birthBaby)) }} Dias / {{ now()->diffInMonths(\Carbon\Carbon::parse($client->birthBaby)) }} Meses" required="">
                            <label for="birthBaby" class="center-align">Idade</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12">
        <form action="{{route('analyze.formulario.create', $challenge->id)}}" method="post">
           @csrf
        <div id="input-fields" class="card card-tabs">
            <div class="card-content">
                <div class="card-title">
                    <div class="row">

                        <div class="col s12 m6 l10">
                            <h4 class="card-title" Meus Dados</h4>
                                Causa dos Despertares:

                        </div>
                    </div>
                </div>
                @if ($babyAge < 90) <div class="card">
                    <div class="card-content">
                        <label>Exterogestação:</label>
                        <textarea class="materialize-textarea" name="ajuste_exterogestacao">Seu bebê ainda está na exterogestação. Lembre que ele ainda possui uma imaturidade intensa e muita necessidade de contato e sucção, o que pode causar alguns despertares, mas a tendência é melhorar progressivamente.</textarea>
                    </div>
            </div>
            @endif
            @if($babyAge < 365) <div class="card">
                <div class="card-content">
                    Fome:
                    <div class="row ">
                        <div class="col s12 m6 l6">
                            <h4 class="card-title ">
                                Você foi ao pediatra nos últimos 30 dias?
                            </h4>
                            <select class="browser-default" name="fome_pediatra" id="fome_pediatra" >
                                <option value="" disabled selected>Selecione</option>
                                <option value="S">SIM</option>
                                <option value="N">NÃO</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l6" id="fome_pediatra_peso">
                            <h4 class="card-title ">
                                O peso atual do seu bebê está adequado?
                            </h4>
                            <select class="browser-default" name="fome_peso_atual" id="fome_peso_atual">
                                <option value="" disabled selected>Selecione</option>
                                <option value="S">SIM</option>
                                <option value="N">NÃO</option>
                                <option value="N">NÃO SEI</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6" id="fome_pediatra_peso_atual_nao">

                            <textarea class="materialize-textarea">É muito importante saber se o peso atual está adequado para podermos descartar fome. Se não estiver, não poderemos descartar essa possível causa. Recomendo levar ao pediatra assim que possível para continuarmos.</textarea>

                        </div>
                        <div class="col s12 m6 l6" id="fome_pediatra_ganho_peso">
                            <h4 class="card-title ">
                                O GANHO de peso do seu bebê nos últimos 30 dais está adequado?
                            </h4>
                            <select class="browser-default" name="fome_ganho_peso" id="fome_ganho_peso" >
                                <option value="" disabled selected>Selecione</option>
                                <option value="S">SIM</option>
                                <option value="N">NÃO</option>
                                <option value="N">NÃO SEI</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6" id="fome_pediatra_ganho_peso_nao">

                            <textarea class="materialize-textarea">É muito importante saber se o ganho de peso está adequado para podermos descartar fome. Se não estiver, não poderemos descartar essa possível causa. Recomendo levar ao pediatra assim que possível para continuarmos.</textarea>

                        </div>

                        <div class="col s12 m6 l6" id="fome_pediatra_fraldas" >
                            <h4 class="card-title ">
                                Você troca de mais de 4 fraldas cheias de urina por dia?
                            </h4>
                            <select class="browser-default" name="fome_fraldas" id="fome_fraldas">
                                <option value="" disabled selected>Selecione</option>
                                <option value="S">SIM</option>
                                <option value="N">NÃO</option>

                            </select>
                        </div>
                        <div class="col s12 m6 l6" id="fome_fraldas_nao">

                            <textarea class="materialize-textarea">Como o principal alimento do bebê é o leite, sabe-se que sempre que houver algum prejuízo na alimentação, a diurese será o primeiro sinal a ser alterado.
Como você referiu diminuição na diurese, o ideal é que procure seu pediatra para avaliar o seu bebê e retornaremos a avaliação após.
</textarea>

                        </div>
                        <div class="col s12 m6 l6" id="fome_pediatra_evacuacao">
                            <h4 class="card-title ">
                                Você consegue identificar um padrão nas evacuações do seu bebê?
                            </h4>
                            <select class="browser-default" name="fome_evacuacao" id="fome_evacuacao">
                                <option value=""  selected>Selecione</option>
                                <option value="S">SIM</option>
                                <option value="N">NÃO</option>

                            </select>
                        </div>
                        <div class="col s12 m6 l6" id="fome_pediatra_evacuacao_nao">

                            <textarea class="materialize-textarea">Esse é um achado mais tardio, em relação ao padrão de diurese, mas que também estará alterado em casos de prejuízos na alimentação do bebê.
Como você referiu não identificar facilmente o padrão de evacuações do seu bebê, o ideal é que procure seu pediatra para avaliar o seu bebê e retornaremos a avaliação após

</textarea>

                        </div>
                        <div class="col s12 m6 l6" id="fome_final">

                            <textarea class="materialize-textarea">Conclusão: Ótimo! Todos os critérios de eficácia na alimentação estão adequados, o que nos leva a concluir que você está com uma boa rotina alimentar, mas como ele ainda é muito pequeno, pode ainda apresentar alguns despertares por fome. Lembrando que dificilmente terá mais do que 2 ou 3 despertares por isso e caso seu bebê acorde mais vezes, devemos continuar buscando novas causas.


</textarea>

                        </div>

                    </div>
                </div>
        </div>
        @endif
        @if($babyAge > 365 && $babyAge < 730) <div class="card">
            <div class="card-content">
                Fome:
                <div class="row ">
                    <div class="col s12 m6 l6" id="fome_pediatra_peso_medio">
                        <h4 class="card-title ">
                            O peso atual do seu bebê está adequado?
                        </h4>
                        <select class="browser-default" name="fome_peso_atual" id="fome_peso_atual_medio" >
                            <option value="" disabled selected>Selecione</option>
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>
                            <option value="N">NÃO SEI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l6" id="fome_pediatra_fraldas_medio">
                        <h4 class="card-title ">
                            Você troca de mais de 4 fraldas cheias de urina por dia?
                        </h4>
                        <select class="browser-default" name="fome_fraldas" id="fome_fraldas_medio" >
                            <option value="" disabled selected>Selecione</option>
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>

                        </select>
                    </div>
                    <div class="col s12 m6 l6" id="fome_pediatra_evacuacao_medio">
                        <h4 class="card-title ">
                            Você consegue identificar um padrão nas evacuações do seu bebê?
                        </h4>
                        <select class="browser-default" name="fome_evacuacoes" id="fome_evacuacao_medio" >
                            <option value="" disabled selected>Selecione</option>
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>

                        </select>
                    </div>
                </div>
            </div>
    </div>
    @endif
    @if($babyAge >= 730) <div class="card">
        <div class="card-content">
            Fome:
            <div class="row ">
                <div class="col s12 m6 l6" id="fome_pediatra_peso_maior" >
                    <h4 class="card-title ">
                        O peso atual do seu bebê está adequado?
                    </h4>
                    <select class="browser-default" name="fome_peso_atual" id="fome_peso_atual_maior" >
                        <option value="" disabled selected>Selecione</option>
                        <option value="S">SIM</option>
                        <option value="N">NÃO</option>
                        <option value="N">NÃO SEI</option>
                    </select>
                </div>

            </div>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-content">
            Dor:
            <div class="row ">
                <div class="col s12 ">
                    <h4 class="card-title ">
                        Você acha que o seu bebê está acordando atualmente por causa de alguma dor ou
                        desconforto? Ex: gases, cólicas, disquesia, refluxo, nascimento de dentes,
                        resfriado, gripe..
                    </h4>
                    <select class="browser-default" name="dor" id="dor" >
                        <option value="" disabled selected>Selecione</option>
                        <option value="S">SIM</option>
                        <option value="N">NÃO</option>
                    </select>
                    <div class="col s12 " id="dor_causa">
                        <h4 class="card-title ">
                            Qual?
                        </h4>
                        <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" value="S" name="dor_colica" id="dor_colica"/>
                                        <span>Cólicas, gases ou disquesia</span>
                                    </label>
                                </p>
                        <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" value="S" name="dor_refluxo" id="dor_refluxo"/>
                                        <span>Refluxo patológico (doença do refluxo)</span>
                                    </label>
                                </p>
                        <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" value="S" name="dor_dente" id="dor_dente"/>
                                        <span>Nascimento de Dentes</span>
                                    </label>
                                </p>
                        <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" value="S" name="dor_outra" id="dor_outra" />
                                        <span>Outra</span>
                                    </label>
                                </p>
                                <div id="dor_outro_desc">
                            <label>Descreva abaixo a dor ou desconforto que você acha que está causando despertares</label>
                        <textarea class="materialize-textarea" name="dor_outra_descricao" id="dor_outra_descricao"></textarea>
                                </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if($babyAge <= 540)
    <div class="card">
        <div class="card-content">
            Salto de desenvolvimento:
            <div class="row ">
                <div class="col s12 ">
                    <h4 class="card-title ">
                        Você acha que o seu bebê está acordando atualmente por causa de um salto de
                        desenvolvimento?
                    </h4>
                    <select class="browser-default" name="salto" id="salto">
                        <option value="" disabled selected>Selecione</option>
                        <option value="S">SIM</option>
                        <option value="N">NÃO</option>
                    </select>
                    <div class="col s12 " id="salto_sim">
                        <h4 class="card-title ">
                            Você consegue perceber novos marcos de desenvolvimento?
                        </h4>
                        <select class="browser-default" name="salto_marcos" id="salto_marcos">
                            <option value="" disabled selected>Selecione</option>
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>
                        </select>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($babyAge > 180 && $babyAge < 540) <div class="card">
        <div class="card-content">
            Angústia da separação:
            <div class="row ">
                <div class="col s12 ">
                    <h4 class="card-title ">
                        Você acha que o seu bebê está acordando atualmente por causa da angústia da separação?
                    </h4>
                    <select class="browser-default" name="angustia" id="angustia">
                        <option value="" disabled selected>Selecione</option>
                        <option value="S">SIM</option>
                        <option value="N">NÃO</option>
                    </select>
                    <div class="col s12 " id="angustia_sim">
                        <h4 class="card-title ">
                            Ele passou a chorar forte QUANDO VOCÊ SAI DO CAMPO DE VISÃO?
                        </h4>
                        <select class="browser-default" name="angustia_sim_campo" id="angustia_sim_campo">
                            <option value="" disabled selected>Selecione</option>
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>
                        </select>
                        <h4 class="card-title ">
                            Se o pai for atender algum despertar à noite, o choro aumenta?
                        </h4>
                        <select class="browser-default" name="angustia_sim_pai" id="angustia_sim_pai">
                            <option value="" disabled selected>Selecione</option>
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>
                        </select>
                    </div>


                </div>
            </div>
        </div>
</div>
@endif
<div class="card">
    <div class="card-content">
        Telas:
        <div class="row ">
            <div class="col s12 ">
                <h4 class="card-title ">
                    Seu bebê é exposto às telas?
                </h4>
                <select class="browser-default" name="telas" id="telas">
                    <option value="" disabled selected>Selecione</option>
                    <option value="S">SIM</option>
                    <option value="N">NÃO</option>
                </select>


            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn"> Enviar</button>

</div>

</div>
<div class="card">
    <div class="card-content row">
        <div class="col s12 m6 l6">
            <label>Ajustes Fome:</label>
            <textarea class="materialize-textarea" id="conclusao_fome" name="conclusao_fome"></textarea>
        </div>
    </div>
    <div class="card-content row">
        <div class="col s12 m6 l6">
            <label>Ajustes Dor:</label>
            <textarea class="materialize-textarea" id="conclusao_dor"  name="conclusao_dor"></textarea>
            <textarea class="materialize-textarea" id="conclusao_dor_colica"  name="conclusao_dor_colica"></textarea>
            <textarea class="materialize-textarea" id="conclusao_dor_refluxo" name="conclusao_dor_refluxo"></textarea>
            <textarea class="materialize-textarea" id="conclusao_dor_dente" name="conclusao_dor_dente"></textarea>
        </div>
    </div>
    <div class="card-content row">
        <div class="col s12 m6 l6">
            <label>Ajustes Salto:</label>
            <textarea class="materialize-textarea" id="conclusao_salto" name="conclusao_salto"></textarea>
        </div>
    </div>
    @if ($babyAge > 180 && $babyAge < 540) <div class="card-content row">
        <div class="col s12 m6 l6">
            <label>Ajustes Angustia da Separação:</label>
            <textarea class="materialize-textarea" id="conclusao_angustia" name="conclusao_angustia"></textarea>
        </div>
</div>
@endif
<div class="card-content row">
    <div class="col s12 m6 l6">
        <label>Ajustes Telas:</label>
        <textarea class="materialize-textarea" id="conclusao_telas" name="conclusao_telas"></textarea>
    </div>
</div>
</div>
</form>
</div>
</div>

@endsection
@section('js')

<script>
    $(document).ready(function() {
        $('.modal').modal({

        });
        //$('#modal1').modal('open');


        $('#fome_pediatra_não').hide();
        $('#fome_pediatra_peso').hide();
        $('#fome_pediatra_peso_atual_nao').hide();
        $('#fome_pediatra_ganho_peso').hide();
        $('#fome_pediatra_ganho_peso_nao').hide();
        $('#fome_pediatra_fraldas').hide();
        $('#fome_fraldas_nao').hide();
        $('#fome_pediatra_evacuacao').hide();
        $('#fome_pediatra_evacuacao_nao').hide();
        $('#fome_final').hide();
        $('#dor_causa').hide();
        $('#salto_sim').hide();
        $('#salto_marcos_sim').hide();
        $('#angustia_sim').hide();
        $('#fome_pediatra_fraldas_medio').hide();
        $('#fome_pediatra_evacuacao_medio').hide();
        $('#fome_pediatra_peso_maior').hide();
        $('#conclusao_dor_colica').hide();
        $('#conclusao_dor_refluxo').hide();
        $('#conclusao_dor_dente').hide();
        $('#dor_outro_desc').hide();
        @if($babyAge >= 730)
        $('#fome_pediatra_peso_maior').show();
        $('#fome_peso_atual_maior').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {

                $('#conclusao_fome').val(
                    'Ótimo! Nessa idade é bem improvável que o seu filho ainda acorde por fome.Seus principais desafios agora são outros, principalmente gasto de energia, birras, falta de bons hábitos e associações. Mas caso suspeite de que a alimentação do seu filho não está sendo o suficiente, me comunique por aqui e passe por uma consulta com seu pediatra ou nutricionista. Trabalharemos em conjunto para te ajudar.'
                );

                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {


                $('#conclusao_fome').val(
                    'É muito importante saber se o peso atual está adequado para podermos descartar fome. Se não estiver, não poderemos descartar essa possível causa. Recomendo levar ao pediatra as-sim que possível para continuarmos.'
                );
                M.textareaAutoResize($('#conclusao_fome'));

            }

        });
        @endif



        @if($babyAge > 365 && $babyAge < 730)
        $('#fome_pediatra_peso_medio').show();

        $('#fome_peso_atual_medio').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {
                $('#fome_pediatra_peso_atual_nao').hide();
                $('#fome_pediatra_fraldas_medio').show();
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_fraldas').hide();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val('');
                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {

                $('#fome_pediatra_ganho_peso').hide();
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_fraldas_medio').hide();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val(
                    'É muito importante saber se o peso atual está adequado para podermos descartar fome. Se não estiver, não poderemos descartar essa possível causa. Recomendo levar ao pediatra assim que possível para continuarmos.'
                );
                M.textareaAutoResize($('#conclusao_fome'));
            }

        });

        $('#fome_fraldas_medio').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {

                $('#fome_pediatra_evacuacao_medio').show();
                $('#conclusao_fome').val('');
                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_evacuacao').hide();
                $('#fome_pediatra_evacuacao_nao').hide();
                $('#conclusao_fome').val(
                    'Como o principal alimento do bebê é o leite, sabe-se que sempre que houver algum prejuízo na alimentação, a diurese será o primeiro sinal a ser alterado. Como você referiu diminuição na diurese, o ideal é que procure seu pediatra para avaliar o seu bebê e retornaremos a avaliação após.'
                );
                M.textareaAutoResize($('#conclusao_fome'));

            }

        });

        $('#fome_evacuacao_medio').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {

                $('#conclusao_fome').val(
                    'Conclusão: Ótimo! Todos os critérios de eficácia na alimentação estão adequados, o que nos leva a concluir que você está com uma boa rotina alimentar e podemos descartar a fome como causa de despertares. E se caso surgir a dúvida pois ele só volta a dormir mamando, lembre que o bebê mama por várias razões, não apenas a fome. Mamar relaxa, acolhe, alivia a dor e a associação. Nós encontraremos a causa para esses despertares.'
                );

                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {


                $('#conclusao_fome').val(
                    'Esse é um achado mais tardio, em relação ao padrão de diurese, mas que também estará alterado em casos de prejuízos na alimentação do bebê. Como você referiu não identificar facilmente o padrão de evacuações do seu bebê, o ideal é que procure seu pediatra para avaliar o seu bebê e retornaremos a avaliação após.'
                );
                M.textareaAutoResize($('#conclusao_fome'));

            }

        });

        @endif








        $('#fome_pediatra').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {
                $('#fome_pediatra_não').hide();
                $('#fome_pediatra_peso_atual_nao').hide();
                $('#fome_pediatra_peso').show();
                $('#fome_pediatra_ganho_peso').hide();
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_fraldas').hide();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val('');
                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {
                $('#fome_pediatra_não').show();
                $('#fome_pediatra_peso_atual_nao').hide();
                $('#fome_pediatra_peso').hide();
                $('#fome_pediatra_ganho_peso').hide();
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_fraldas').hide();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val(
                    'É muito importante ter a avaliação do seu pediatra para podermos descartar fome. Se ele não avaliou, não poderemos descartar essa possível causa. Recomendo levar ao pediatra assim que possível para continuarmos.'
                );
                M.textareaAutoResize($('#conclusao_fome'));
            }

        });

        $('#fome_peso_atual').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {
                $('#fome_pediatra_peso_atual_nao').hide();
                $('#fome_pediatra_ganho_peso').show();
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_fraldas').hide();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val('');
                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {

                $('#fome_pediatra_ganho_peso').hide();
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_fraldas').hide();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val(
                    'É muito importante saber se o peso atual está adequado para podermos descartar fome. Se não estiver, não poderemos descartar essa possível causa. Recomendo levar ao pediatra assim que possível para continuarmos.'
                );
                M.textareaAutoResize($('#conclusao_fome'));
            }

        });

        $('#fome_ganho_peso').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {
                $('#fome_pediatra_peso_atual_nao').hide();
                $('#fome_pediatra_fraldas').show();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val('');
                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {

                $('#fome_pediatra_fraldas').hide();
                $('#fome_fraldas_nao').hide();
                $('#conclusao_fome').val(
                    'É muito importante saber se o ganho de peso está adequado para podermos descartar fome. Se não estiver, não poderemos descartar essa possível causa. Recomendo levar ao pediatra assim que possível para continuarmos.'
                );
                M.textareaAutoResize($('#conclusao_fome'));

            }

        });

        $('#fome_fraldas').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {

                $('#fome_pediatra_evacuacao').show();
                $('#conclusao_fome').val('');
                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {
                $('#fome_pediatra_ganho_peso_nao').hide();
                $('#fome_pediatra_evacuacao').hide();
                $('#fome_pediatra_evacuacao_nao').hide();
                $('#conclusao_fome').val(
                    'Como o principal alimento do bebê é o leite, sabe-se que sempre que houver algum prejuízo na alimentação, a diurese será o primeiro sinal a ser alterado. Como você referiu diminuição na diurese, o ideal é que procure seu pediatra para avaliar o seu bebê e retornaremos a avaliação após.'
                );
                M.textareaAutoResize($('#conclusao_fome'));

            }

        });
        $('#fome_evacuacao').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {
                @if($babyAge <= 90)
                $('#conclusao_fome').val(
                    'Conclusão: Ótimo! Todos os critérios de eficácia na alimentação estão adequados, o que nos leva a concluir que você está com uma boa rotina alimentar, mas como ele ainda é muito pequeno, pode ainda apresentar alguns despertares por fome. Lembrando que dificilmente terá mais do que 2 ou 3 despertares por isso e caso seu bebê acorde mais vezes, devemos continuar buscando novas causas.'
                );
                @endif
                @if($babyAge > 90)
                $('#conclusao_fome').val(
                    'Conclusão: Ótimo! Todos os critérios de eficácia na alimentação estão adequados, o que nos leva a concluir que você está com uma boa rotina alimentar e podemos descartar a fome como causa de despertares. E se caso surgir a dúvida pois ele só volta a dormir mamando, lembre que o bebê mama por várias razões, não apenas a fome. Mamar relaxa, acolhe, alivia a dor e a associação. Nós encontraremos a causa para esses despertares.'
                );
                @endif
                M.textareaAutoResize($('#conclusao_fome'));
            }
            if (opt == 'N') {


                $('#conclusao_fome').val(
                    'Esse é um achado mais tardio, em relação ao padrão de diurese, mas que também estará alterado em casos de prejuízos na alimentação do bebê. Como você referiu não identificar facilmente o padrão de evacuações do seu bebê, o ideal é que procure seu pediatra para avaliar o seu bebê e retornaremos a avaliação após.'
                );
                M.textareaAutoResize($('#conclusao_fome'));

            }

        });

        $('#dor').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {


                $('#conclusao_dor').val('É importante descartar todo tipo de desconforto do bebê!');
                M.textareaAutoResize($('#conclusao_dor'));
                $('#dor_causa').show();

            }
            if (opt == 'N') {

                $('#conclusao_dor').val('Conclusão: Ótimo! Então está descartada como possível causa de despertares!');
                M.textareaAutoResize($('#conclusao_dor'));
                $('#dor_causa').hide();
            }

        });

        $('#dor_colica').click(function() {
            if($('#dor_colica').is(':checked')){
                $('#conclusao_dor_colica').show();
            $('#conclusao_dor_colica').val('Cólicas, gases e disquesia realmente podem causar dor e desconforto no bebê, consequentemente, pode causar despertares. Por isso eu criei o curso gratuito "Descomplicando as cólicas do bebê”, no qual eu ensino tudo sobre essa importante causa de dor. Você já assistiu? Se não, vou deixar aqui o link para você: https://youtube.com/playlist?list=PLaQhiV_BorwFDdu3bs90TQfZCTVoSJtQx Além disso, é muito importante que o seu pediatra esteja ciente do que está acontecendo porque infe-lizmente nós não podemos abordar alguns temas como diagnóstico e tratamento individuais aqui. Mas é muito importante que você entenda que a dor não pode ser uma razão para você abandonar os ajustes e o acompanhamento. Na verdade, o ideal é que, se possível, você atue paralelamente no alívio do desconforto e nos ajustes de sono. Conta conosco para isso!');
                M.textareaAutoResize($('#conclusao_dor_colica'));
               
            }else
            {
                $('#conclusao_dor_colica').hide();
               
            }
               
});
        $('#dor_refluxo').click(function() {
            
            if($('#dor_refluxo').is(':checked')){
                $('#conclusao_dor_refluxo').show();
            $('#conclusao_dor_refluxo').val('Quanto ao refluxo, é importante lembrar que existe uma grande diferença entre “refluxo fisiológico”, que é aquele bebê que golfa, não causa grandes desconfortos ou comprometimento no ganho de peso, logo, também não é o suficiente para causar despertares. Enquanto a doença do refluxo é a condição patológica que realmente pode trazer prejuízos à saúde do seu filho, como dor e perda de peso, re-sultando em despertares à noite bastante desconfortáveis. Se o seu caso realmente for doença do refluxo, sugiro fazer os ajustes de sono concomitantes ao seu tratamento afim de estabilizar o desconforto, ou seja, não é preciso esperar a cura desse refluxo para começar a ter melhorias no sono do bebê.');
                M.textareaAutoResize($('#conclusao_dor_refluxo'));
               
            }else
            {
                $('#conclusao_dor_refluxo').hide();
               
            }
               
});
        $('#dor_dente').click(function() {
            
            if($('#dor_dente').is(':checked')){
                $('#conclusao_dor_dente').show();
            $('#conclusao_dor_dente').val('Quanto ao nascimento de dentes, essa é outra importante causa de dor, desconforto e de despertares, mas que costuma ser facilmente resolvida com medidas não medicamentosas como mordedores gela-dos. Se a dor estiver muito intensa, você pode oferecer analgésicos simples prescritos pelo seu pedi-atra. OBS: Não é comum que seja causa de muitos despertares noturnos.');
                M.textareaAutoResize($('#conclusao_dor_dente'));
               
            }else
            {
                $('#conclusao_dor_dente').hide();
               
            }
               
});
        $('#dor_outra').click(function() {
            
            if($('#dor_outra').is(':checked')){
                $('#dor_outro_desc').show();
           
               
            }else
            {
                $('#dor_outro_desc').hide();
               
            }
               
});



        $('#salto').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {


                $('#conclusao_salto').val('');
                M.textareaAutoResize($('#conclusao_salto'));
                $('#salto_sim').show();

            }
            if (opt == 'N') {

                $('#conclusao_salto').val('Conclusão: Ótimo! Os saltos são momentos especiais de desenvolvimento do bebê, mas que podem vir acompanhados de despertares. Que bom que não é o seu caso, vamos passar para a próxima!');
                M.textareaAutoResize($('#conclusao_salto'));
                $('#salto_sim').hide();
                $('#salto_marcos_sim').hide();

            }

        });

        $('#salto_marcos').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {


                $('#conclusao_salto').val('Os saltos são mesmo importantes causas de despertares porque o bebê pode ficar mais alerta ou assus-tado devido a tantas novidades. Pode ser que fique inevitável desenvolver associações nesse período, mas se esse for o caso, nós iremos desfaze-la assim que o salto acabar. Além disso, é importante verificarmos quais necessidades de sono do seu bebê estão mudan-do. E o desafio é fundamental para isso! Conte conosco.');
                M.textareaAutoResize($('#conclusao_salto'));
                $('#salto_sim').show();
                $('#salto_marcos_sim').show();


            }
            if (opt == 'N') {

                $('#conclusao_salto').val('Lembra que o salto de desenvolvimento é identificado pelos novos marcos de desenvolvimento! E não pelo aumento de despertares, ok?');
                M.textareaAutoResize($('#conclusao_salto'));

                $('#salto_marcos_sim').hide();

            }

        });

        $('#angustia').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {


                $('#conclusao_angustia').val('');
                M.textareaAutoResize($('#conclusao_angustia'));
                $('#angustia_sim').show();

            }
            if (opt == 'N') {

                $('#conclusao_angustia').val('Conclusão: Ótimo! A angústia da separação não costuma causar tantos despertares assim. O mais comum é haver o aumento da intensidade do choro durante esses despertares que foram causados por outras razões. Vamos continuar nossa análise!');
                M.textareaAutoResize($('#conclusao_angustia'));
                $('#angustia_sim').hide();


            }

        });

        $('#angustia_sim_pai').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {
                if ($('#angustia_sim_campo').children("option:selected").val() == 'S') {

                    $('#conclusao_angustia').val('Pela idade e pelas suas respostas, faz sentido pensar em angústia da separação, mas preciso te lembrar que ela não costuma causar tantos despertares assim. O mais comum é haver o aumento da intensidade do choro durante esses despertares que foram causados por outras razões. Vamos continuar nossa análise!');
                    M.textareaAutoResize($('#conclusao_angustia'));
                    $('#angustia_sim').show();
                }
            }
            if (opt == 'N') {

                $('#conclusao_angustia').val('Pela idade, até faz sentido pensar, mas pelas suas respostas, não ficou muito claro se realmente se trata de angústia da separação. De qualquer forma, preciso te lembrar que ela não costuma causar tantos despertares assim. O mais comum é haver o aumento da intensidade do choro durante esses despertares que foram causados por outras razões. Vamos continuar nossa análise!');
                M.textareaAutoResize($('#conclusao_angustia'));



            }

        });

        $('#angustia_sim_campo').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {
                if ($('#angustia_sim_pai').children("option:selected").val() == 'S') {

                    $('#conclusao_angustia').val('Pela idade e pelas suas respostas, faz sentido pensar em angústia da separação, mas preciso te lembrar que ela não costuma causar tantos despertares assim. O mais comum é haver o aumento da intensidade do choro durante esses despertares que foram causados por outras razões. Vamos continuar nossa análise!');
                    M.textareaAutoResize($('#conclusao_angustia'));
                    $('#angustia_sim').show();
                }
            }
            if (opt == 'N') {

                $('#conclusao_angustia').val('Pela idade, até faz sentido pensar, mas pelas suas respostas, não ficou muito claro se realmente se trata de angústia da separação. De qualquer forma, preciso te lembrar que ela não costuma causar tantos despertares assim. O mais comum é haver o aumento da intensidade do choro durante esses despertares que foram causados por outras razões. Vamos continuar nossa análise!');
                M.textareaAutoResize($('#conclusao_angustia'));



            }

        });

        $('#telas').on('change', function() {

            var opt = $(this).children("option:selected").val();
            if (opt == 'S') {


                $('#conclusao_telas').val('Lembre que as telas podem atrapalhar o sono do bebê de 2 formas:   Pela exposição à luz azul, que prejudica o sono e a produção de melatonina;   Pelo hiperestímulo que ocorre devido ao excesso de dopamina liberado no organismo quando o bebê é exposto. A Sociedade Brasileira de Pediatria e a Academia Americana de Pediatria recomendam que o bebê não deve ser exposto às telas antes dos 2 anos de idade.');
                M.textareaAutoResize($('#conclusao_telas'));


            }
            if (opt == 'N') {

                $('#conclusao_telas').val('Conclusão: Ótimo! A Sociedade Brasileira de Pediatria e a Academia Americana de Pediatria recomendam que o bebê não deve ser exposto às telas antes dos 2 anos de idade.');
                M.textareaAutoResize($('#conclusao_telas'));

            }

        });


    });
</script>


<script>
    $(document).ready(function() {
        $('.modal').modal({

        });
        $('#modal1').modal('open');



    });
</script>


@endsection