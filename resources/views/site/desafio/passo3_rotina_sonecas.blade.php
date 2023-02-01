@extends('site.desafio.layouts.app')
@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Passo 3: - Rotina de Sonecas</h4>
            <textarea class="materialize-textarea">Agora a nossa pré-análise será de um dos pontos mais importantes de todos, dentro dos 4 passos do sono do bebê. Avaliaremos a rotina de sonecas do seu bebê.

Lembrando que após o preenchimento do seu desafio, você poderá tirar todas as suas dúvidas, dificuldades, particularidades e resultados no seu chat exclusivo. Não se preocupe, que o seu desafio não se resume a uma pré-análise automática!

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
                            <input type="hidden" value="FEITO" name="passo3_rotina">

            <div id="input-fields" class="card card-tabs">
                <div class="card-content">
                    <div class="card-title">
                       Janelas de Sono
                        <div class="row">

                          
                                <div class="col s12 m6">
                                    <div class="card">
                                        <div class="card-content">
                                            <table>
                                                <tr>
                                                    <td>
                                                        Média de Janela de Sono Adequada
                                                    </td>
                                                    <td>
                                                        {{getSinalSono(getIdade($client->birthBaby))->janelaIdealFim}} minutos
                                                    </td>
                                                </tr>
                                                    <tr>
                                                    <td>
                                                        Média de Janela de Sono Adequado do seu Bebê
                                                    </td>
                                                    <td>
                                                        {{round($media_janelas, 0)}} Minutos
                                                    </td>
                                                <tr>
                                                   
                                                   
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="card">
                                        <div class="card-content">
                                            <table>
                                                <tr>
                                                    <td>
                                                       Quantidade de Sonecas abaixo de 40 minutos:
                                                    </td>
                                                    <td>
                                                        {{$qtd_sonecas_inadequadas}} 
                                                    </td>
                                                </tr>
                                                   
                                                   
                                                   
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                           

                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="col s12">
             <div class="card">
                 <div class="card-content row">
                    <div class="col s12 m12 l12">
                        <label>Ajustes Rotina de Sonecas:</label>
                      @if(count($janelas)>0)
                      
                        <textarea id="conclusao_rotina_sonecas" class="materialize-textarea" name="ajuste_rotina_sonecas" >Para que a sua compreensão fique mais clara, entenda que janela de sono é o equivalente à soma entre o intervalo que o bebê sentiu sono e o intervalo do ritual da soneca, ok?

Com isso, vi que o seu bebê possui pelo menos uma janela de sono acima do esperado para a idade dele e para as necessidades de sono registradas.
Primeiro precisamos observar que a média de tempo que o seu bebê levou para sentir sono foi de   {{round($media_janelas, 0)}} minutos. E se não estiver claro, essa média foi de acordo com as suas anotações.
Além disso, é preciso entender que após o sentir sono, o bebê deve dormir em até 30 minutos, nor-malmente, já que se passar mais tempo acordado, as chances dele estar cansado demais para dormir bem, são muito grandes.
Por isso, podemos concluir que a MÉDIA de janela de sono do seu bebê, é de {{ round($media_janelas, 0) + 30}} minutos.
Com isso, sugiro que, CASO NÃO PERCEBA sinais de sono antes, comece o desacelerar em até  {{round($media_janelas, 0)}} minutos, para que ele durma em até 30 minutos e permaneça dentro da janela de sono espera-da.
</textarea>
                        @endif
                      @if(count($janelas)==0)
                      
                        <textarea id="conclusao_rotina_sonecas" class="materialize-textarea" name="ajuste_rotina_sonecas" >Para que a sua compreensão fique mais clara, entenda que janela de sono é o equivalente à soma entre o intervalo que o bebê sentiu sono e o intervalo do ritual da soneca, ok?
Para que a sua compreensão fique mais clara, entenda que janela de sono é o equivalente à soma entre o intervalo que o bebê sentiu sono e o intervalo do ritual da soneca, ok?

Com isso, vi que o seu bebê possui pelo menos uma janela de sono acima do esperado para a idade, que é de até JANELA DE SONO MÁXIMA, logo, precisaremos avaliar com calma cada um dos 5 pilares das sonecas.

Mas sugiro, nesse primeiro momento, que busque janelas de sono de ATÉ JANELA DE SONO MÁXIMA, mas caso perceba sinais de sono antes disso, comece o desacelerar e o ritual.
Saberemos com mais precisão quando conseguir observar bem os sinais de sono do bebê

JANELA DE SONO MÁXIMA:
{{getSinalSono(getIdade($client->birthBaby))->janelaIdealFim}} minutos



</textarea>
                        @endif
                    </div>
                </div>
                
             </div>
        </div>
        <div class="col s12">
             <div class="card">
                 <div class="card-content row">
                    <div class="col s12 m12 l12">
                        <label>Duração das Sonecas:</label>
                      @if($qtd_sonecas_inadequadas>0)
                      
                        <textarea id="conclusao_rotina_sonecas" class="materialize-textarea" name="ajuste_duracao_sonecas" >Vi que pelo menos uma soneca do seu bebê apresenta duração inferior a 40 minutos, o que indica que essa soneca não foi suficientemente reparadora.
	A duração mínima de um ciclo de sono do bebê é de 40 minutos, logo, o esperado é a soneca tenha no mínimo essa duração e que ele acorde ativo e alegre. Enquanto se tiver menos de 40 minutos, ou se o bebê acordar com sono ou cansado, isso nos indicará que ela precisa ser prolongada e que precisamos avaliar cada um dos 5 pilares das sonecas.
	Enquanto isso, para prolongar uma soneca, o ideal é que você consiga se antecipar ao despertar e já ninar ou amamentar o bebê, fazendo com que ele permaneça dormindo, porém isso não é tão simples de acontecer e nem todas conseguem se antecipar. Nesse caso, faça o bebê dormir novamente o mais rápido que puder, não importa como (ninando, amamentando etc).
	E caso não consiga que o bebê volte a dormir, pelo menos permaneça no ambiente do sono o suficiente para completar os 40 minutos da soneca. Essa soneca não será tão reparadora, mas seria pior se saísse do quarto.

</textarea>
                        @endif
                      @if($qtd_sonecas_inadequadas==0)
                      
                        <textarea id="conclusao_rotina_sonecas" class="materialize-textarea" name="ajuste_duracao_sonecas" >Vi que todas as sonecas do seu bebê estão com duração próxima ou maior que 40 minutos, o que é ótimo pois garante que ele está tendo um sono reparador.
</textarea>
                        @endif
                    </div>
                </div>
                
             </div>
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
 M.textareaAutoResize($('#conclusao_rotina_sonecas'));
            });
        </script>

    @endsection
