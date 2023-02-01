@extends('site.desafio.layouts.app')
@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Passo 3: - Pilares:</h4>
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
            <form action="{{route('analyze.formulario.update', $challenge->id)}}" method="post">
                @csrf
              {{ method_field('PUT') }}
                                          <input type="hidden" value="FEITO" name="passo3_pilares">

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
        @if (getIdade($client->birthBaby) > 180)
            <div class="col s12">
                  

                <div id="input-fields" class="card card-tabs">
                    <div class="card-content">
                        <div class="card-title">
                            Gasto de Energia
                            <div class="row">


                                <div class="col s12 m6">
                                    <div class="card">
                                        <div class="card-content">
                                            <table>
                                                <tr>
                                                    <td>
                                                        Quantidade de Despertares Maiores que 30 minutos
                                                    </td>
                                                    <td>
                                                        {{ $qtd_despertares_inadequadas }}
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
        @endif
        <div class="col s12">
            <div id="input-fields" class="card card-tabs">
                <div class="card-content">
                    <div class="card-title">
                        Sinais de Sono
                        <div class="row">


                            <div class="col s12 m6">
                                <div class="card">
                                    <div class="card-content">
                                        <table>

                                            <tr>
                                                <td>
                                                    Quantidade de Sinais de Sono acima do Ideal - DIA 7
                                                </td>
                                                <td>
                                                    {{ count($janelas) }}
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
            <div id="input-fields" class="card card-tabs">
                <div class="card-content">
                    <div class="card-title">
                        Desacelerar <div class="row">


                            <div class="col s12 m6">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="row ">
                                            <div class="col s12 ">
                                                <h4 class="card-title ">
                                                    Você lembra de desacelerar após perceber sinais de sono?
                                                </h4>
                                                <select class="browser-default" name="desacelera" id="desacelera">
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



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div id="input-fields" class="card card-tabs">
                <div class="card-content">
                    <div class="card-title">
                        Ambiente do Sono <div class="row">


                            <div class="col s12 m6">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="row ">
                                            <div class="col s12 ">
                                                <h4 class="card-title ">
                                                    Suas sonecas são no claro ou escuro?
                                                </h4>
                                                <select class="browser-default" name="ambiente_luz" id="ambiente_luz">
                                                    <option value="" disabled selected>Selecione</option>
                                                    <option value="escuro">Escuro</option>
                                                    <option value="claro">Parcialmente Escuro</option>
                                                    <option value="claro">Algumas no claro</option>

                                                </select>


                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col s12 ">
                                                <h4 class="card-title ">
                                                    Suas sonecas são no silêncio ou no barulho?
                                                </h4>
                                                <select class="browser-default" name="ambiente_som" id="ambiente_som">
                                                    <option value="" disabled selected>Selecione</option>
                                                    <option value="silencio">Silêncio</option>
                                                    <option value="ruido_branco">Com Ruído Branco / Música de Ninar
                                                    </option>
                                                    <option value="barulho">Algumas com barulho</option>

                                                </select>


                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col s12 ">
                                                <h4 class="card-title ">
                                                    Como está a temperatura nas suas sonecas?
                                                </h4>
                                                <select class="browser-default" name="ambiente_temperatura"
                                                    id="ambiente_temperatura">
                                                    <option value="" disabled selected>Selecione</option>
                                                    <option value="agradavel">Agradável</option>
                                                    <option value="frio">Frio</option>
                                                    <option value="calor">Calor</option>
                                                    <option value="nao_sei">Não sei / Varia</option>

                                                </select>


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
     
        @if ($qtd_rituais_inadequadas > 0)
            <div class="col s12">
                <div id="input-fields" class="card card-tabs">
                    <div class="card-content">
                        <div class="card-title">
                            Ritual do Sono <div class="row">


                                <div class="col s12 m6">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="row ">
                                                <div class="col s12 ">
                                                    <h4 class="card-title ">
                                                        Há choro no ritual?
                                                    </h4>
                                                    <select class="browser-default" name="ritual_choro"
                                                        id="ritual_choro">
                                                        <option value="" disabled selected>Selecione</option>
                                                        <option value="S">SIM</option>
                                                        <option value="N">NÃO</option>

                                                    </select>

                                                    <div class="col s12 " id="ritual_choro_sim">
                                                        <h4 class="card-title ">
                                                            Em qual momento o choro costuma começar a acontecer?
                                                        </h4>
                                                        <select class="browser-default" name="ritual_choro_sim_select"
                                                            id="ritual_choro_sim_select">
                                                            <option value="" disabled selected>Selecione</option>
                                                            <option value="quarto">Assim que entra no quarto</option>
                                                            <option value="meio">No meio do ritual</option>
                                                            <option value="apos_dormir">Poucos minutos após dormir</option>
                                                            <option value="berco">Ao colocar no berço</option>
                                                        </select>
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
            </div>
        @endif
        <div class="col s12">
            <div class="card">
                <div class="card-content row">
                    <div class="col s12 m12 l12">
                        <label>Gasto de Energia:</label>
                        @if ($qtd_despertares_inadequadas > 0)
                            @if (getIdade($client->birthBaby) > 180 && getIdade($client->birthBaby) < 360)
                                <textarea id="conclusao_rotina_gasto_energia" class="materialize-textarea" name="gasto_energia_ajuste">Estou vendo que em pelo menos 1 despertar do bebê, ele permaneceu muito tempo acordado, o que pode ser sugestivo de baixo gasto de energia. Nesse caso, lembra de caprichar no gasto de energia do bebê!
			Nessa idade, não costuma ser algo tão difícil, basta lembrar de deixar o maior tempo possível no chão e/ou no tapete para que ele se movimente livremente.
</textarea>
                            @endif
                            @if (getIdade($client->birthBaby) >= 360 && getIdade($client->birthBaby) < 720)
                                <textarea id="conclusao_rotina_gasto_energia" class="materialize-textarea" name="gasto_energia_ajuste">Estou vendo que em pelo menos 1 despertar do bebê, ele permaneceu muito tempo acordado, o que pode ser sugestivo de baixo gasto de energia. Nesse caso, lembra de caprichar no gasto de energia do bebê!
			Nessa idade, costuma a ficar mais difícil mesmo, pois seu bebê está se tornan-do uma criança cada vez mais cheia de energia. Lembre de estimula-lo a se movimentar o máximo que puder.
</textarea>
                            @endif
                            @if (getIdade($client->birthBaby) >= 720)
                                <textarea id="conclusao_rotina_gasto_energia" class="materialize-textarea" name="gasto_energia_ajuste">Estou vendo que em pelo menos 1 despertar do seu filho, ele permaneceu muito tempo acordado, o que pode ser sugestivo de baixo gasto de energia. Nesse caso, lembra de caprichar no gasto de energia!
			Nessa idade, costuma ser algo mais difícil, porque é uma criança cheia de ener-gia. Por isso, não deixe de estimula-lo o máximo possível a estar sempre ativo.	
</textarea>
                            @endif
                        @endif
                        @if ($qtd_despertares_inadequadas == 0)
                            <textarea id="conclusao_rotina_gasto_energia" class="materialize-textarea" name="gasto_energia_ajuste">Estou vendo que as durações dos despertares estão curtas, o que fala contra a hipótese do baixo gasto de energia.
</textarea>
                        @endif
                    </div>
                </div>
                <div class="card-content row">
                    <div class="col s12 m12 l12">
                        <label>Sinais de Sono:</label>
                        @if (count($janelas) > 0)
                            <textarea  class="materialize-textarea" name="sinais_sono_ajuste"> Nós já conversamos sobre os sinais de sono do bebê no Passo 1.	
	Mas eu vi aqui que você ainda deve estar com dificuldade de perceber os sinais de sono do seu bebê pois ainda está referindo que eles demoram muito para acontecer.
	Veja com atenção à recomendação dada na pré-análise do Passo 1 que eu fiz no Dia 7.
	Reforço para tentar observar esses sinais, mas me conta se tiver alguma dificuldade.
</textarea>
                        @endif

                        @if (count($janelas) == 0)
                            <textarea id="conclusao_rotina_gasto_energia" class="materialize-textarea" name="sinais_sono_ajuste">Estou vendo aqui que você concluiu seu desafio percebendo todos os sinais de sono dentro do inter-valo esperado para a idade. Parabéns!
Vamos seguir adiante!

</textarea>
                        @endif
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m12 l12">
                            <label>Desacelerar:</label>


                            <textarea id="conclusao_desacelera" class="materialize-textarea" name="desacelerar_ajuste"></textarea>

                        </div>
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m12 l12">
                            <label>Ambiente - Luminosidade:</label>


                            <textarea id="conclusao_ambiente_luminosidade" class="materialize-textarea" name="ambiente_luz_ajuste"></textarea>

                        </div>
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m12 l12">
                            <label>Ambiente - som:</label>


                            <textarea id="conclusao_ambiente_som" class="materialize-textarea" name="ambiente_som_ajuste"></textarea>

                        </div>
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m12 l12">
                            <label>Ambiente - temperatura:</label>


                            <textarea id="conclusao_ambiente_temperatura" class="materialize-textarea" name="ambiente_temperatura_ajuste"></textarea>

                        </div>
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m12 l12">
                            <label>Ritual do Sono:</label>

                            @if ($qtd_rituais_inadequadas == 0)
                                <textarea id="conclusao_ritual_sono" class="materialize-textarea" name="ritual_sono_ajuste">
                            Vi que os rituais estão com menos de 30 minutos! Que ótimo saber que está conseguindo relaxar rápi-do o seu bebê! Esse é, sem dúvidas, o critério mais importante a ser avaliado aqui.
		Vamos seguir em frente! Parabéns!
                        </textarea>
                            @endif
                            @if ($qtd_rituais_inadequadas > 0)
                                <textarea id="conclusao_ritual_sono" class="materialize-textarea" name="ritual_sono_ajuste"></textarea>
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

                    $('#ritual_choro_sim').hide();


                    M.textareaAutoResize($('#conclusao_rotina_gasto_energia'));

                    $('#desacelera').on('change', function() {

                        var opt = $(this).children("option:selected").val();
                        if (opt == 'S') {


                            $('#conclusao_desacelera').val(
                                'Ótimo! Isso é muito importante para que o bebê não vá ao ambiente do sono irritado, chorando ou eufórico. Todos esses aumentariam as chances do bebê perceber que está sendo colocado para dormir, o que causaria irritabilidade e dificultaria o ritual do sono. Por isso, sempre após perceber os sinais de sono do seu bebê, passe alguns minutos (5 a 10) desacelerando o seu bebê. Você pode fazer isso retirando brinquedo com luzes, brincadeiras mais agitadas, caminhando pela casa, dançando… qualquer coisa que o deixe calmo. '
                                );
                            M.textareaAutoResize($('#conclusao_desacelera'));


                        }
                        if (opt == 'N') {

                            $('#conclusao_desacelera').val(
                                'Desacelerar é muito importante para que o bebê não vá ao ambiente do sono irritado, chorando ou eufórico. Todos esses aumentariam as chances do bebê perceber que está sendo colocado para dormir, o que causaria irritabilidade e dificultaria o ritual do sono. Caso tenha dificuldade em desacelerar, lembre que basta remover brincadeiras mais agitadas e brinquedos que estimulem muito, como os brinquedos com muitas luzes, além caminhar pela casa, dançar… qualquer coisa que o deixe calmo. 		Depois de 5 a 10 minutos, quando estiver mais calmo, você leva para o ambiente do sono, que é justamente o próximo tópico a ser analisado.'
                                );
                            M.textareaAutoResize($('#conclusao_desacelera'));

                        }

                    });
                    $('#ritual_choro').on('change', function() {

                        var opt = $(this).children("option:selected").val();
                        if (opt == 'S') {


                            $('#ritual_choro_sim').show();



                        }
                        if (opt == 'N') {

                            $('#ritual_choro_sim').hide();
                            $('#conclusao_ritual_sono').val(
                                'Eu vi aqui que pelo menos um ritual ainda ultrapassa os 30 minutos e é fundamental que você entenda que o ideal é que não demore muito para que o bebê não fique tão cansado e irritado, o que compro-meterá a qualidade desse sono.Talvez seja o momento de mudar o ritual, ou pelo menos, deixa-lo mais curto.O ritual está longo, mas pelo menos não tem choro. Nesse caso, o ideal é buscar uma forma de encur-ta-lo. Seja tentando fazer todo o seu ritual mais rápido, ou mesmo retirando uma parte do seu ritual. Por exemplo, aproximadamente aos 7 meses da Olívia, eu precisei retirar o banho da noite pois o ritual estava longo demais, mas como ela ainda precisava do banho após o jantar, a melhor forma que eu encontrei foi dar o banho ANTES dela sentir sono. Assim eu dou o banho, visto e aproximadamente na hora de mamar que ela começa a emitir sinais de sono.'
                                );
                            M.textareaAutoResize($('#conclusao_ritual_sono'));

                        }

                    });

                    $('#ritual_choro_sim_select').on('change', function() {

                        var opt = $(this).children("option:selected").val();
                        if (opt == 'quarto') {

                            $('#conclusao_ritual_sono').val(
                                'Eu vi aqui que pelo menos um ritual ainda ultrapassa os 30 minutos e é fundamental que você entenda que o ideal é que não demore muito para que o bebê não fique tão cansado e irritado, o que compro-meterá a qualidade desse sono.Talvez seja o momento de mudar o ritual, ou pelo menos, deixa-lo mais curto. Nesse caso, o bebê chora porque percebeu que está sendo colocado para dormir. Você conseguirá resolver caprichando na hora de desacelerar e come-çando o seu ritual com um ambiente o mais DESAJUSTADO possível. Assim você diminui as chances dele perceber a diferença entre o ambiente de fora e o ambiente do sono e vai ajustando aos poucos.'
                                );
                            M.textareaAutoResize($('#conclusao_ritual_sono'));




                        }
                        if (opt == 'meio') {


                            $('#conclusao_ritual_sono').val(
                                'Eu vi aqui que pelo menos um ritual ainda ultrapassa os 30 minutos e é fundamental que você entenda que o ideal é que não demore muito para que o bebê não fique tão cansado e irritado, o que compro-meterá a qualidade desse sono.Talvez seja o momento de mudar o ritual, ou pelo menos, deixa-lo mais curto.Nesse caso, é comum haver um “gatilho do choro”, ou seja, algo que normalmente desencadeia o cho-ro, por fazer com que ele perceba que está sendo colocado para dormir. Você consegue perceber algum? Por exemplo, para alguns o choro acontece na hora de colocar para arrotar. Para outros é quando deita no braço, entre vários outros… Quando isso acontece, nós devemos remover esse gatilho.Por exemplo, se o bebê costuma chorar na hora do banho ou de sair dele e você já tentou de tudo e não consegue evitar o estresse e o choro, é melhor dar o banho em outro momento, para que esse estresse (e o cortisol envolvido) não atrapalhe o sono do bebê. Se não for possível retirar esse gatilho, devemos optar por altera-lo.Por exemplo, se o bebê chora muito na hora de colocar para arrotar, o que acaba atrapalhando o sono, mas ele ainda precisa disso, nós não podemos simplesmente parar de colocar para arrotar. A solução para esse caso seria colocar de outra forma. Não é obrigatório sempre colocar o bebê para arrotar de uma única forma, o importante é que ele fique na vertical por alguns minutos.Outro exemplo, se o bebê chora na hora de deitar no seu braço para ser ninado, por perceber que será colocado para dormir, você pode passar a coloca-lo de bruço nos seus braços ou pernas, em cima de uma almofada por exemplo.O importante é que esse gatiho que costuma causar choro deixe de acontecer.'
                                );
                            M.textareaAutoResize($('#conclusao_ritual_sono'));

                        }
                        if (opt == 'apos_dormir') {


                            $('#conclusao_ritual_sono').val(
                                'Eu vi aqui que pelo menos um ritual ainda ultrapassa os 30 minutos e é fundamental que você entenda que o ideal é que não demore muito para que o bebê não fique tão cansado e irritado, o que compro-meterá a qualidade desse sono.Talvez seja o momento de mudar o ritual, ou pelo menos, deixa-lo mais curto.Isso acontece muito! Você faz o ritual, amamenta, nina, ele dorme e… acorda poucos minutos depois! Desesperador, ne?Mas, calma! Pensa comigo! O seu ritual funcionou, ele dormiu!Quando isso acontecer, respira bem fundo e tenta manter a calma para continuar seu ritual. Continuar ninando. Ele está com sono e o seu ritual funciona, o que acontece é que às vezes ele percebe que dormiu e tentar acordar de vez, mas se você continuar ninando, ele vai dormir novamente.Se isso for algo muito frequente e/ou que você tem dificuldade para que ele durma novamente, aí sim, vale a pena pensar em mudar o final do ritual.'
                                );
                            M.textareaAutoResize($('#conclusao_ritual_sono'));

                        }
                        if (opt == 'berco') {


                            $('#conclusao_ritual_sono').val(
                                'Eu vi aqui que pelo menos um ritual ainda ultrapassa os 30 minutos e é fundamental que você entenda que o ideal é que não demore muito para que o bebê não fique tão cansado e irritado, o que compro-meterá a qualidade desse sono.Talvez seja o momento de mudar o ritual, ou pelo menos, deixa-lo mais curto.Nesse caso, você tem duas opções, manter no colo para garantir a soneca, ou desfazer a associação, mas para isso, precisamos avaliar antes o passo 4 com calma.O mais importante nesse momento é que você perceba que o problema não está no seu ritual!Ele funcionou! O bebê dormiu.Ele acordou ao ser colocado no berço, apenas.Falaremos mais disso no Passo 4.'
                                );
                            M.textareaAutoResize($('#conclusao_ritual_sono'));

                        }

                    });



                    $('#ambiente_luz').on('change', function() {

                        var opt = $(this).children("option:selected").val();
                        if (opt == 'escuro') {


                            $('#conclusao_ambiente_luminosidade').val(
                                'Ótimo! Esse é um ponto ainda muito polêmico, porém muito importante! É ideal que as sonecas sejam feitas no escuro para garantir um sono reparador e para que seu bebê chegue ao final do dia bem e descansado, ao invés de cansado demais por não ter tirado boas sonecas.'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_luminosidade'));


                        }
                        if (opt == 'claro') {

                            $('#conclusao_ambiente_luminosidade').val(
                                'Esse é um ponto ainda muito polêmico, porém muito importante!É ideal que as sonecas sejam feitas no escuro para garantir um sono reparador e para que seu bebê chegue ao final do dia bem e descansado, ao invés de cansado demais por não ter tirado boas sonecas. E não se engane apenas com a duração das sonecas! Eu gosto sempre de lembrar do exemplo de uma viagem de carro, na qual nós até dormimos por longos intervalos, mas não descan-samos nada e chegamos ainda mais cansados. Por isso, faça um esforço para escurecer o ambiente, seja com cartolina preta, cortina blackout, saco de lixo… não importa como, o que importa é o resultado! Vai valer a pena!'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_luminosidade'));

                        }

                    });

                    $('#ambiente_som').on('change', function() {

                        var opt = $(this).children("option:selected").val();
                        if (opt == 'silencio') {


                            $('#conclusao_ambiente_som').val(
                                'Ótimo! Esse é um ponto ainda muito polêmico, porém muito importante! É ideal que as sonecas sejam feitas no silêncio ou com os ruídos abafados pelo ruído branco/música de ninar para garantir um sono reparador e para que seu bebê chegue ao final do dia bem e descansado, ao invés de cansado demais por não ter tirado boas sonecas.'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_som'));


                        }
                        if (opt == 'ruido_branco') {

                            $('#conclusao_ambiente_som').val(
                                'Ótimo! Esse é um ponto ainda muito polêmico, porém muito importante! É ideal que as sonecas sejam feitas no silêncio ou com os ruídos abafados pelo ruído branco/música de ninar para garantir um sono reparador e para que seu bebê chegue ao final do dia bem e descansado, ao invés de cansado demais por não ter tirado boas sonecas.'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_som'));

                        }
                        if (opt == 'barulho') {

                            $('#conclusao_ambiente_som').val(
                                'Esse é um ponto ainda muito polêmico, porém muito importante!É ideal que as sonecas sejam feitas no silêncio ou com os ruídos abafados pelo ruído branco/música de ninar para garantir um sono reparador e para que seu bebê chegue ao final do dia bem e descansado, ao invés de cansado demais por não ter tirado boas sonecas.E não se engane apenas com a duração das sonecas! Eu gosto sempre de lembrar do exemplo de uma viagem de carro, na qual nós até dormimos por longos intervalos, mas não descan-samos nada e chegamos ainda mais cansados.Por isso, faça um esforço para silenciar o ambiente ou abafar esses ruídos com uma barreira acústica, como o ruído branco ou música de ninar… não importa como, o que importa é o resultado! Vai valer a pena!'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_som'));

                        }

                    });

                    $('#ambiente_temperatura').on('change', function() {

                        var opt = $(this).children("option:selected").val();
                        if (opt == 'agradavel') {


                            $('#conclusao_ambiente_temperatura').val(
                                'Ótimo! É ideal que as sonecas sejam feitas em um ambiente com a temperatura agradável para garantir um sono reparador e para que seu bebê chegue ao final do dia bem e descansado, ao invés de cansado demais por não ter tirado boas sonecas.'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_temperatura'));


                        }
                        if (opt == 'frio') {

                            $('#conclusao_ambiente_temperatura').val(
                                'Tem certeza que está frio? A melhor forma de avaliar se essa temperatura está desconfortável para o bebê é avaliando o seu tórax, abdome ou dorso, ou seja, o tronco do bebê. Se ao tocar no bebê, a sua pele estiver fria, pálida ou rendilhada, ele está sentindo frio. Não é bom avaliar pela cabeça do bebê porque ela é naturalmente mais quente que o restante do corpo e porque é comum haver suor na cabeça durante o sono profundo, mesmo não es-tando com calor. Ambas as situações podem te atrapalhar bastante na hora de avaliar. Além disso, as extremidades do bebê (mãos e pés) são naturalmente mais frias que o restante do corpo, devido à sua menor circulação de sangue, o que pode te dar a falsa sensação de frio. Caso realmente esteja frio, o indicado é caprichar no agasalho, saco de dormir (que permita que os braços fiquem livres) ou mesmo no uso do aquecedor. E lembrar que o uso de mantas é contraindicado antes de 1 ano pelo maior risco de acidentes!'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_temperatura'));

                        }
                        if (opt == 'calor') {

                            $('#conclusao_ambiente_temperatura').val(
                                'Tem certeza que está calor? A melhor forma de avaliar se essa temperatura está desconfortável para o bebê é avaliando o seu tórax, abdome ou dorso, ou seja, o tronco do bebê. Se ao tocar no bebê, a sua pele estiver quente, avermelhada ou suada, ele está sentindo calor. Não é bom avaliar pela cabeça do bebê porque ela é naturalmente mais quente que o restante do corpo e porque é comum haver suor na cabeça durante o sono profundo, mesmo não es-tando com calor. Ambas as situações podem te atrapalhar bastante na hora de avaliar. Além disso, as extremidades do bebê (mãos e pés) são naturalmente mais frias que o restante do corpo, devido à sua menor circulação de sangue, o que pode te dar a falsa sensação de frio. Caso realmente esteja calor, o indicado é usar menos roupas na hora de dormir e/ou usar algo para aliviar, como um ar condicionado ou ventilador, desde que não fique virado diretamen-te para o bebê.'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_temperatura'));

                        }
                        if (opt == 'nao_sei') {

                            $('#conclusao_ambiente_temperatura').val(
                                'A melhor forma de avaliar se essa temperatura está desconfortável para o bebê é avaliando o seu tó-rax, abdome ou dorso, ou seja, o tronco do bebê. Se ao tocar no bebê, a sua pele estiver quente, avermelhada ou suada, ele está sentindo calor. Enquan-to se estiver fria, pálida ou rendilhada, ele está sentindo frio. Caso esteja frio, o indicado é caprichar no agasalho, saco de dormir (que permita que os braços fiquem livres) ou mesmo no uso do aquecedor. E lembrar que o uso de mantas é contraindi-cado antes de 1 ano pelo maior risco de acidentes! Mas se estiver calor, o indicado é usar menos roupas na hora de dormir e/ou usar algo para aliviar, como um ar condicionado ou ventilador, desde que não fique virado diretamente para o bebê.'
                                );
                            M.textareaAutoResize($('#conclusao_ambiente_temperatura'));

                        }

                    });



                });
            </script>

        @endsection
