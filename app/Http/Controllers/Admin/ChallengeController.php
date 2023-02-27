<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Builder;
use App\Models\Category;
use App\Models\Message;
use App\Notifications\ChallengeBonusNotification;

class ChallengeController extends Controller
{
   public function __construct(Challenge $challenge)
   {
      $this->repository = $challenge;
   }

   public function availables()
   {
      $challenges = $this->repository->join('clients', 'clients.id','challenges.client_id' )->where('status', 'ENVIADO')
      ->where('tipo','=',null)
      ->where('clients.user_id',Auth::user()->id)
      ->where('challenges.user_id', null)
      ->orderBy('sended_at')->paginate();
     
      return view('admin.challenges.availables.index', compact('challenges'));
   }

   public function new_availables()
   {
      $challenges = $this->repository->where('status', 'ENVIADO')
      ->where('tipo','=','1')
      ->where('user_id', null)
      ->orderBy('sended_at')->paginate();
      
      return view('admin.challenges.availables.new-index', compact('challenges'));
   }

   public function myChallenges()
   {




      $challenges = Auth::user()->challenges()->orderBy('status','asc')->orderBy('answered_at','desc')->get();
      return view('admin.challenges.meus.index', compact('challenges'));
   }

   public function getChallenge($id)
   {
     
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }
     
      $user = Auth::user();
     
      $this->repository->find($id)->update(['user_id' => $user->id, 'status' => 'ANALISE']);
      return redirect()->route('challenge.availables');
   }

   public function showAvailables($id)
   {
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);

      if($challenge->tipo=='1'){
         return view('admin.challenges.availables.new-show', compact('challenge'));

      }else{
         return view('admin.challenges.availables.show', compact('challenge'));

      }

   }

   public function showMyChallenge($id)
   {


      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);


      if ($challenge->tipo == '1') {
         return view('admin.challenges.availables.new-show', compact('challenge'));
      } else {
         return view('admin.challenges.availables.show', compact('challenge'));
      }
   }

   public function showMyChallengeBlack($id)
   {


      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);

      if ($challenge->tipo == '1') {
         return view('admin.challenges.meus.new-black', compact('challenge'));
      } else {
         return view('admin.challenges.meus.show-black', compact('challenge'));
      }

   }

   public function showMyChallengeNoWindow($id)
   {


      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);


      return view('admin.challenges.meus.show-no-window', compact('challenge'));
   }

   public function responder($id)
   {
     
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }
      if ($challenge->tipo == 1) {

      }
      else{

      $challenge = $this->repository->with('client')->find($id);
      $client = $challenge->client()->first();
      $form = $challenge->form()->first();
      $janela = getJanela(getIdade($client->birthBaby));
      $qtd_sinais_sono_tardio=0;

     
   
     
      $qtd_janelas_inadequadas_fim = count($challenge->naps->where('window', '>', $janela->janelaIdealFim));
      $qtd_janelas_inadequadas_inicio = count($challenge->naps->where('window', '<', $janela->janelaIdealInicio));
      $qtd_janelas_rituals_inadequadas_fim = count($challenge->rituals->where('window', '>', $janela->janelaIdealFim));
      $qtd_janelas_rituals_inadequadas_inicio = count($challenge->rituals->where('window', '<', $janela->janelaIdealInicio));
      $qtd_janelas_longas=$qtd_janelas_inadequadas_fim+$qtd_janelas_rituals_inadequadas_fim;
      $qtd_janelas_inadequadas = $qtd_janelas_inadequadas_fim + $qtd_janelas_inadequadas_inicio + $qtd_janelas_rituals_inadequadas_fim + $qtd_janelas_rituals_inadequadas_inicio;
      
      $qtd_rituals_inicio_inadequados = count($challenge->rituals->where('start', '>', '21:00:00'));
      $qtd_sonecas_inadequadas = count($challenge->naps->where('duration', '<', 40));
      $qtd_sonecas_longas = count($challenge->naps->where('duration', '>', 120));
      $qtd_ritual_sonecas_longo = count($challenge->naps->where('windowSignalSlept', '>', 30));
      $qtd_ritual_inadequado = count($challenge->rituals->where('duration', '>', 30));
      $qtd_dias_acordou_cedo = count($challenge->analyzes->where('timeWokeUp', '<', '06:00:00'));
      $qtd_dias_acordou_tarde = count($challenge->analyzes->where('timeWokeUp', '>', '08:00:00'));
      $qtd_despertares_inadequadas = count($challenge->wakes->where('duration', '>', 60));
      $acordou_mais_cedo = $challenge->analyzes->min('timeWokeUp');
      $acordou_mais_tarde = $challenge->analyzes->max('timeWokeUp');
      foreach($challenge->naps as $item){
         if($item->window-$item->windowSignalSlept>$janela->janelaIdealFim-30){
          $qtd_sinais_sono_tardio++;
         }
      }
      foreach($challenge->rituals as $item){
       if($item->window-$item->windowSignalSlept>$janela->janelaIdealFim-30){
        $qtd_sinais_sono_tardio++;
       }
    }

    $passo1['orientacao']="";
    $passo1['sinalSono']="";
      $passo2['imaturidade'] = "";
      $passo2['fome'] = "";
      $passo2['dor'] = "";
      $passo2['salto'] = "";
      $passo2['angustia'] = "";
      $passo2['telas'] = "";
      $passo2['stress'] = "";
      $passo3['despertar'] = "";
      $passo3['ritualBomDia'] = "";
      $passo3['rotinaAlimentar'] = "";
      $passo3['ritualNoturno'] = "";
      $passo3['ambienteLuzes'] = "";
      $passo3['ambienteRuidos'] = "";
      $passo3['ambienteTemperatura'] = "";
      $passo3['gastoEnergia'] = "";
      $passo3['gastoEnergiaDespertares'] = "";
      $passo3['gastoEnergiaChoro'] = "";
      $passo3['gastoEnergiaAcordouCedo'] = "";
      $passo3['gastoEnergiaConclusao'] = "";
      $passo3['ambienteSonecasLuzes'] = "";
      $passo3['ambienteSonecasRuidos'] = "";
      $passo3['ambienteSonecasTemperatura'] = "";
      $passo3['duracaoSonecas'] = "";
      $passo3['duracaoSonecasDespertar'] = "";
      $passo3['duracaoSonecasFome'] = "";
      $passo3['duracaoSonecasRitual'] = "";
      $passo3['sonecasCurtas'] = "";


      $babyAge = getIdade($client->birthBaby);
      $sex = getSex($client->sexBaby);
      $situacaoGanhoPeso = getGanhoPeso($babyAge, $challenge->form->weightGain);

      $passo1['mensagem'] = Category::where('sex', $sex)
         ->where(
            'description',
            'PASSO 1 - MENSAGEM GERAL '
         )
         ->first()->answers()->get();

         if($qtd_janelas_inadequadas<=1){
            if($qtd_sinais_sono_tardio<=1 && $qtd_ritual_sonecas_longo<=1){
               $passo1['orientacao'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Janela de sono adequada e sinais de sono adequados e ritual < 30 minutos'
               )
               ->first()->answers()->get();
            }
            if($qtd_sinais_sono_tardio<=1 && $qtd_ritual_sonecas_longo>1){
               $passo1['orientacao'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Janela de sono adequada e sinais de sono adequados e ritual > 30 minutos'
               )
               ->first()->answers()->get();
            }
         }

         if($qtd_janelas_inadequadas>1){
            if($qtd_sinais_sono_tardio>1 && $qtd_ritual_sonecas_longo>1){
               $passo1['orientacao'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Janela de sono longa e sinais de sono longos e ritual > 30 minutos'
               )
               ->first()->answers()->get();
               
            }
            if($qtd_sinais_sono_tardio>1 && $qtd_ritual_sonecas_longo<=1){
               $passo1['orientacao'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Janela de sono longa e sinais de sono longos e ritual < 30 minutos'
               )
               ->first()->answers()->get();
               
            }
            if($qtd_sinais_sono_tardio<=1 && $qtd_ritual_sonecas_longo>1){
               $passo1['orientacao'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Janela de sono longa e sinais de sono bons e ritual < 30 minutos'
               )
               ->first()->answers()->get();
               
            }
         }
         if($qtd_sinais_sono_tardio>1 && $qtd_janelas_inadequadas>1){
            if($babyAge<120){
               $passo1['sinalSono'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Sinais de sono longos - 0 a 119 dias'
               )
               ->first()->answers()->get();   
            }
            if($babyAge>=120 && $babyAge<180){
               $passo1['sinalSono'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Sinais de sono longos - 120 a 179 dias'
               )
               ->first()->answers()->get();   
            }
            if($babyAge>=180 && $babyAge<270){
               $passo1['sinalSono'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Sinais de sono longos - 180 a 269 dias'
               )
               ->first()->answers()->get();   
            }
            if($babyAge>=270 && $babyAge<365){
               $passo1['sinalSono'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Sinais de sono longos - 270 a 364 dias'
               )
               ->first()->answers()->get();   
            }
            if($babyAge>=365 && $babyAge<540){
               $passo1['sinalSono'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Sinais de sono longos - 365 a 539 dias'
               )
               ->first()->answers()->get();   
            }
            if($babyAge>540){
               $passo1['sinalSono'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 1 - Sinais de sono longos - 540 dias ou mais'
               )
               ->first()->answers()->get();   
            }
         }

       


      if ($babyAge < 90) {
         $passo2['imaturidade'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - IMATURIDADE'
            )
            ->first()->answers()->get();
      }


      if ($babyAge >= 365) {
         $passo2['fome'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - FOME - Maior que 1 ano'
            )
            ->first()->answers()->get();
      }

      if ($babyAge < 365) {
         if ($situacaoGanhoPeso == "Adequado") {
            $passo2['fome'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 2 - FOME - Menor que 1 ano + Ganho de peso ADEQUADO'
               )
               ->first()->answers()->get();
         }
         if ($situacaoGanhoPeso == "Inadequado") {
            $passo2['fome'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 2 - FOME - Menor que 1 ano + Ganho de peso INADEQUADO'
               )
               ->first()->answers()->get();
         }
         if ($situacaoGanhoPeso == "Vazio") {
            $passo2['fome'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 2 - FOME - Menor que 1 ano + Não sabe ganho de peso'
               )
               ->first()->answers()->get();
         }
      }

      if ($form->conclusionAche == "N" && $babyAge < 90) {
         $passo2['dor'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - DOR - NÃO CONFIRMADO menor que 3 meses'
            )
            ->first()->answers()->get();
      }
      if ($form->conclusionAche == "N" && $babyAge >= 90) {

         $passo2['dor'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - DOR - NÃO CONFIRMADO maior que 3 meses'
            )
            ->first()->answers()->get();
      }
      if ($form->conclusionAche == "S") {

         $passo2['dor'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - DOR - CONFIRMADO'
            )
            ->first()->answers()->get();
      }
      if ($form->conclusionJump == "S") {
         $passo2['salto'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - SALTO - CONFIRMADO'
            )
            ->first()->answers()->get();
      }
      if ($form->conclusionJump == "N") {
         $passo2['salto'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - SALTO - NÃO CONFIRMADO'
            )
            ->first()->answers()->get();
      }

      if ($form->conclusionAnguish == "S" && $babyAge > 180) {
         $passo2['angustia'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - ANGÚSTIA - CONFIRMADO'
            )
            ->first()->answers()->get();
      }
      if ($form->conclusionAnguish == "N" && $babyAge > 180) {
         $passo2['angustia'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 2 - ANGÚSTIA - NÃO CONFIRMADO'
            )
            ->first()->answers()->get();
      }

      $passo2['telas'] = Category::where('sex', $sex)
         ->where(
            'description',
            'PASSO 2 - TELAS'
         )
         ->first()->answers()->get();

      $passo2['stress'] = Category::where('sex', $sex)
         ->where(
            'description',
            'PASSO 2 - STRESS'
         )
         ->first()->answers()->get();

      $passo2['mensagem'] = Category::where('sex', $sex)
         ->where(
            'description',
            'PASSO 2 - MENSAGEM GERAL '
         )
         ->first()->answers()->get();
      if ($qtd_dias_acordou_tarde > 0) {
         $passo3['despertar'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 3 - DESPERTAR - acorda depois de 08:00'
            )
            ->first()->answers()->get();
      }

      if ($qtd_dias_acordou_cedo > 0) {
         $passo3['despertar'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 3 - DESPERTAR - acorda antes de 06:00'
            )
            ->first()->answers()->get();
      }

      if ($qtd_dias_acordou_cedo == 0 && $qtd_dias_acordou_tarde == 0) {

         if (strtotime($acordou_mais_tarde) - strtotime($acordou_mais_cedo) > strtotime('01:00:00')) {
            $passo3['despertar'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 3 - DESPERTAR - acorda entre 06:00 e 08:00 + Diferença entre o horário mais cedo e o mais tarde > 60 min'
               )
               ->first()->answers()->get();
         } else {
            $passo3['despertar'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 3 - DESPERTAR - acorda entre 06:00 e 08:00 + Diferença entre o horário mais cedo e o mais tarde < 60 min'
               )
               ->first()->answers()->get();
         }
      }

      if ($form->ritualGoodMorning == "N") {
         $passo3['ritualBomDia'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 3 - Ritual do bom dia - NÃO'
            )
            ->first()->answers()->get();
      }

      if ($form->ritualGoodMorning == "S") {
         if (
            $form->ritualGoodMorningLight == "S" &&
            $form->ritualGoodMorningNoise == "S" &&
            $form->ritualGoodMorningStimulus == "S" &&
            $form->ritualGoodMorningRemove == "S"
         ) {
            $passo3['ritualBomDia'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 3 - Ritual do bom dia - SIM + marcou tudo'
               )
               ->first()->answers()->get();
         } else {
            $passo3['ritualBomDia'] = Category::where('sex', $sex)
               ->where(
                  'description',
                  'PASSO 3 - Ritual do bom dia - SIM + NÃO marcou tudo'
               )
               ->first()->answers()->get();
         }
      }

      if ($form->routineDifficulties == 'N') {
         $passo3['rotinaAlimentar'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 3 - ROTINA ALIMENTAR - SEM DIFICULDADES'
            )
            ->first()->answers()->get();
      }

      if ($form->routineDifficulties == 'S') {
         $passo3['rotinaAlimentar'] = Category::where('sex', $sex)
            ->where(
               'description',
               'PASSO 3 - ROTINA ALIMENTAR - COM DIFICULDADES'
            )
            ->first()->answers()->get();
      }

      if($qtd_ritual_inadequado>0){
         $passo3['ritualNoturno']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - RITUAL NOTURNO - INADEQUADO')
         ->first()->answers()->get();
       }

       if($qtd_ritual_inadequado==0){
         if($challenge->form->ritualType=="S"){
           $passo3['ritualNoturno']=Category::where('sex',$sex)
           ->where('description', 
           'PASSO 3 - RITUAL NOTURNO - ADEQUADO + sem choro')
           ->first()->answers()->get();
         }else{
          

           $passo3['ritualNoturno']=Category::where('sex',$sex)
           ->where('description', 
           'PASSO 3 - RITUAL NOTURNO - ADEQUADO + choro')
           ->first()->answers()->get();
         }
        
       }

       if($form->environmentRitualLights=="E"){
         $passo3['ambienteLuzes']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - AMBIENTE - LUZES - ADEQUADO')
         ->first()->answers()->get();
       }else{
         $passo3['ambienteLuzes']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - AMBIENTE - LUZES - INADEQUADO')
         ->first()->answers()->get();
       }

       if($form->environmentRitualNoises=="S"){
         $passo3['ambienteRuidos']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - AMBIENTE - RUIDOS- ADEQUADO')
         ->first()->answers()->get();
       }else{
         $passo3['ambienteRuidos']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - AMBIENTE - RUIDOS- INADEQUADO')
         ->first()->answers()->get();
       }

       if($form->environmentRitualTemperature=="A"){
         $passo3['ambienteTemperatura']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - AMBIENTE - TEMPERATURA- ADEQUADO')
         ->first()->answers()->get();
       }else{
         $passo3['ambienteTemperatura']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - AMBIENTE - TEMPERATURA- INADEQUADO')
         ->first()->answers()->get();
       }

       if($form->environmentNapsLights=='T'){
         $passo3['ambienteSonecasLuzes']=Category::where('sex',$sex)
           ->where('description', 
           'PASSO 3 - SONECA- AMBIENTE- LUZES - ADEQUADO')
           ->first()->answers()->get();
       }else{
         $passo3['ambienteSonecasLuzes']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- AMBIENTE- LUZES - INADEQUADO')
         ->first()->answers()->get();
       }

       if($form->environmentNapsNoises=='S'){
         $passo3['ambienteSonecasRuidos']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- AMBIENTE- RUÍDOS - ADEQUADO')
         ->first()->answers()->get();
       }else{
         $passo3['ambienteSonecasRuidos']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- AMBIENTE- RUÍDOS - INADEQUADO')
         ->first()->answers()->get();
       }

       if($form->environmentNapsTemperature=='A'){
         $passo3['ambienteSonecasTemperatura']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- AMBIENTE- TEMPERATURA - ADEQUADO')
         ->first()->answers()->get();
       }else{
         $passo3['ambienteSonecasTemperatura']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- AMBIENTE- TEMPERATURA- INADEQUADO')
         ->first()->answers()->get();
       }

       if($babyAge>180 ){
         if($form->energyExpenditure=="Adequado"){
         $passo3['gastoEnergia']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- GASTO DE ENERGIA- ADEQUADO')
         ->first()->answers()->get();
       }else{
         $passo3['gastoEnergia']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- GASTO DE ENERGIA- INADEQUADO')
         ->first()->answers()->get();

         if($form->ritualType!='Sem'){
           
           $passo3['gastoEnergiaChoro']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- GASTO DE ENERGIA- INADEQUADO - Choro')
         ->first()->answers()->get();
         }
         if($qtd_despertares_inadequadas>0){
           $passo3['gastoEnergiaDespertares']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- GASTO DE ENERGIA- INADEQUADO - Despertar')
         ->first()->answers()->get();
         }
         if($qtd_dias_acordou_cedo>0){
           $passo3['gastoEnergiaAcordouCedo']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- GASTO DE ENERGIA- INADEQUADO - Acordou cedo')
         ->first()->answers()->get();
         }
         if($form->ritualType=='Sem' 
         && $qtd_despertares_inadequadas==0
         && $qtd_dias_acordou_cedo==0
         ){
           $passo3['gastoEnergiaConclusao']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- GASTO DE ENERGIA- INADEQUADO - CONCLUSÃO')
         ->first()->answers()->get();
         }
      }
      }

      if($qtd_sonecas_inadequadas>0){
         $passo3['sonecasCurtas']="SONECAS CURTAS";
       }
       if($qtd_sonecas_inadequadas==0 && $qtd_sonecas_longas==0){
        
         $passo3['duracaoSonecas']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- DURAÇÃO - ADEQUADO')
         ->first()->answers()->get();
         
       }
       if($qtd_sonecas_inadequadas==0 && $qtd_sonecas_longas>0){
         if($babyAge<=28){
           $passo3['duracaoSonecas']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- DURAÇÃO - LONGA < 28')
         ->first()->answers()->get();
         
         }else
         if($babyAge>28 && $babyAge<=90)
         {
           $passo3['duracaoSonecas']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- DURAÇÃO - LONGA > 28 <90')
         ->first()->answers()->get();
         }else
         if($babyAge>90){
           
           $passo3['duracaoSonecasDespertar']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- DURAÇÃO - LONGA > 90 - DESPERTAR')
         ->first()->answers()->get();
           
           if($form->conclusionHungry=='S' || $situacaoGanhoPeso=="Inadequado"){
             $passo3['duracaoSonecasFome']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- DURAÇÃO - LONGA > 90 - FOME')
         ->first()->answers()->get();
           }
           if($qtd_rituals_inicio_inadequados>0){
             $passo3['duracaoSonecasRitual']=Category::where('sex',$sex)
             ->where('description', 
             'PASSO 3 - SONECA- DURAÇÃO - LONGA > 90 - RITUAL')
             ->first()->answers()->get();
             
           }
           if($form->conclusionHungry=='N'
           && ($situacaoGanhoPeso=="Adequado" || $situacaoGanhoPeso=="")
           && $qtd_despertares_inadequadas==0
           && $qtd_rituals_inicio_inadequados==0){
             $passo3['duracaoSonecas']=Category::where('sex',$sex)
         ->where('description', 
         'PASSO 3 - SONECA- DURAÇÃO - ADEQUADO')
         ->first()->answers()->get();
           }

         }

       }
       $passo1['mensagem'] = stringReplace($passo1['mensagem'][rand(0, count($passo1['mensagem']) - 1)]->response, $client);
       if (!$passo1['orientacao'] == "") {
         $passo1['orientacao'] = stringReplace($passo1['orientacao'][rand(0, count($passo1['orientacao']) - 1)]->response, $client);
      }
       if (!$passo1['sinalSono'] == "") {
         $passo1['sinalSono'] = stringReplace($passo1['sinalSono'][rand(0, count($passo1['sinalSono']) - 1)]->response, $client);
      }
      if (!$passo2['imaturidade'] == "") {
         $passo2['imaturidade'] = stringReplace($passo2['imaturidade'][rand(0, count($passo2['imaturidade']) - 1)]->response, $client);
      }
      if (!$passo2['fome'] == "") {
         $passo2['fome'] = stringReplace($passo2['fome'][rand(0, count($passo2['fome']) - 1)]->response, $client);
      }
      $passo2['salto'] = stringReplace($passo2['salto'][rand(0, count($passo2['salto']) - 1)]->response, $client);
      if (!$passo2['angustia'] == "") {
         $passo2['angustia'] = stringReplace($passo2['angustia'][rand(0, count($passo2['angustia']) - 1)]->response, $client);
      }
      $passo2['telas'] = stringReplace($passo2['telas'][rand(0, count($passo2['telas']) - 1)]->response, $client);
      $passo2['stress'] = stringReplace($passo2['stress'][rand(0, count($passo2['stress']) - 1)]->response, $client);
      $passo2['mensagem'] = stringReplace($passo2['mensagem'][rand(0, count($passo2['mensagem']) - 1)]->response, $client);
      $passo2['dor'] = stringReplace($passo2['dor'][rand(0, count($passo2['dor']) - 1)]->response, $client);
      $passo3['despertar'] = stringReplace($passo3['despertar'][rand(0, count($passo3['despertar']) - 1)]->response, $client);
      $passo3['ritualBomDia'] = stringReplace($passo3['ritualBomDia'][rand(0, count($passo3['ritualBomDia']) - 1)]->response, $client);
      if (!$passo3['rotinaAlimentar'] == "") {
         $passo3['rotinaAlimentar'] = stringReplace($passo3['rotinaAlimentar'][rand(0, count($passo3['rotinaAlimentar']) - 1)]->response, $client);
      }
      $passo3['ritualNoturno']= stringReplace($passo3['ritualNoturno'][rand(0,count($passo3['ritualNoturno'])-1)]->response, $client);
      $passo3['ambienteLuzes']= stringReplace($passo3['ambienteLuzes'][rand(0,count($passo3['ambienteLuzes'])-1)]->response, $client);
      $passo3['ambienteRuidos']= stringReplace($passo3['ambienteRuidos'][rand(0,count($passo3['ambienteRuidos'])-1)]->response, $client);
      $passo3['ambienteTemperatura']= stringReplace($passo3['ambienteTemperatura'][rand(0,count($passo3['ambienteTemperatura'])-1)]->response, $client);
      $passo3['ambienteSonecasLuzes']= stringReplace($passo3['ambienteSonecasLuzes'][rand(0,count($passo3['ambienteSonecasLuzes'])-1)]->response, $client);
      $passo3['ambienteSonecasRuidos']= stringReplace($passo3['ambienteSonecasRuidos'][rand(0,count($passo3['ambienteSonecasRuidos'])-1)]->response, $client);
      $passo3['ambienteSonecasTemperatura']= stringReplace($passo3['ambienteSonecasTemperatura'][rand(0,count($passo3['ambienteSonecasTemperatura'])-1)]->response, $client);
     
       if(!$passo3['gastoEnergia']==""){
         $passo3['gastoEnergia']= stringReplace($passo3['gastoEnergia'][rand(0,count($passo3['gastoEnergia'])-1)]->response, $client);        
       }
       if(!$passo3['gastoEnergiaChoro']==""){
         $passo3['gastoEnergiaChoro']= stringReplace($passo3['gastoEnergiaChoro'][rand(0,count($passo3['gastoEnergiaChoro'])-1)]->response, $client);        
       }
       if(!$passo3['gastoEnergiaDespertares']==""){
         $passo3['gastoEnergiaDespertares']= stringReplace($passo3['gastoEnergiaDespertares'][rand(0,count($passo3['gastoEnergiaDespertares'])-1)]->response, $client);        
       }
       if(!$passo3['gastoEnergiaAcordouCedo']==""){
         $passo3['gastoEnergiaAcordouCedo']= stringReplace($passo3['gastoEnergiaAcordouCedo'][rand(0,count($passo3['gastoEnergiaAcordouCedo'])-1)]->response, $client);                
       }
       if(!$passo3['gastoEnergiaConclusao']==""){
         $passo3['gastoEnergiaConclusao']= stringReplace($passo3['gastoEnergiaConclusao'][rand(0,count($passo3['gastoEnergiaConclusao'])-1)]->response, $client);                        
       }
     
       if(!$passo3['duracaoSonecas']==""){
         $passo3['duracaoSonecas']= stringReplace($passo3['duracaoSonecas'][rand(0,count($passo3['duracaoSonecas'])-1)]->response, $client);        
       }
       if(!$passo3['duracaoSonecasDespertar']==""){
         $passo3['duracaoSonecasDespertar']= stringReplace($passo3['duracaoSonecasDespertar'][rand(0,count($passo3['duracaoSonecasDespertar'])-1)]->response, $client);        
       }
       if(!$passo3['duracaoSonecasFome']==""){
         $passo3['duracaoSonecasFome']= stringReplace($passo3['duracaoSonecasFome'][rand(0,count($passo3['duracaoSonecasFome'])-1)]->response, $client);        
       }
       if(!$passo3['duracaoSonecasRitual']==""){
         $passo3['duracaoSonecasRitual']=stringReplace($passo3['duracaoSonecasRitual'][rand(0,count($passo3['duracaoSonecasRitual'])-1)]->response, $client);                
       }
      return view('admin.challenges.meus.responder', [
         'challenge' => $challenge,
         'passo1' => (object)$passo1,
         'passo2' => (object)$passo2, 
         'passo3' => (object)$passo3,
         'qtd_ritual_sonecas_longo' =>$qtd_ritual_sonecas_longo,
         'qtd_sonecas_inadequadas'=>$qtd_sonecas_inadequadas,
         'qtd_sinais_sono_tardio' =>$qtd_sinais_sono_tardio,
        'qtd_janelas_inadequadas' =>$qtd_janelas_longas,
        'qtd_dias_acordou_cedo'=>$qtd_dias_acordou_cedo,
        'qtd_dias_acordou_tarde'=>$qtd_dias_acordou_tarde,
        'acordou_mais_cedo'=>$acordou_mais_cedo,
        'acordou_mais_tarde'=>$acordou_mais_tarde
      
      ]);
   }
   }

   public function responderUpdate($id, Request $request)
   {
    
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);
      if($challenge->status=='RESPONDIDO'){
         $challenge->update([
            'status' => 'RESPONDIDO', 'passo1' => $request->passo1,
            'passo2' => $request->passo2,
            'passo3_despertar' => $request->passo3_despertar,
            'passo3_rotina_alimentar' => $request->passo3_rotina_alimentar,
            'passo3_rotina_sonecas' => $request->passo3_rotina_sonecas,
            'passo3_ambiente_sonecas' => $request->passo3_ambiente_sonecas,
            'passo3_sono_noturno' => $request->passo3_sono_noturno,
            'passo3_ambiente_noturno' => $request->passo3_ambiente_noturno,
            'passo4_associacoes_sonecas' => $request->passo4_associacoes_sonecas,
            'passo4_associacoes_noturno' => $request->passo4_associacoes_noturno,
            'conclusao' => $request->conclusao,
         ]);
      }
      if($challenge->status=='ANALISE'){
         $challenge->update([
            'status' => 'RESPONDIDO', 'answered_at'=>now(), 'passo1' => $request->passo1,
            'passo2' => $request->passo2,
            'passo3_despertar' => $request->passo3_despertar,
            'passo3_rotina_alimentar' => $request->passo3_rotina_alimentar,
            'passo3_rotina_sonecas' => $request->passo3_rotina_sonecas,
            'passo3_ambiente_sonecas' => $request->passo3_ambiente_sonecas,
            'passo3_sono_noturno' => $request->passo3_sono_noturno,
            'passo3_ambiente_noturno' => $request->passo3_ambiente_noturno,
            'passo4_associacoes_sonecas' => $request->passo4_associacoes_sonecas,
            'passo4_associacoes_noturno' => $request->passo4_associacoes_noturno,
            'conclusao' => $request->conclusao,
         ]);
         if($challenge->client->bonus==1){
            $challenge->notify(new ChallengeBonusNotification());

         }
      }
      


      return redirect()->route('challenge.meus.show', $id);
   }

   public function respostas($id){
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);

      return view('admin.challenges.meus.respostas', compact('challenge'));
   }

   public function respostas2($id)
   {
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);

      return view('admin.challenges.meus.respostas-2', compact('challenge'));
   }

   public function chat($id)
   {
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);


      return view('admin.challenges.meus.chat', compact('challenge'));
   }


   public function chat2($id)
   {
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);


      return view('admin.challenges.meus.chat-2', compact('challenge'));
   }

   public function chatStore(Request $request, $id)
   {
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }

      $challenge = $this->repository->with('client')->find($id);

      $chat = $challenge->chat()->first();
      $chat->update(['status' => 'odilo']);
      $chat->messages()->create(['content' => $request->message, 'type' => 2]);
      return redirect()->route('challenge.meus.chat', $challenge->id);
   }

   public function chatAbertos()
   {
      $chats = Auth::user()->chats()->where('chats.status', 'mae')->with('challenge')->where('challenges.status', 'RESPONDIDO')->get();

      return view('admin.chats.abertos', compact('chats'));
   }

   public function chats()
   {
      $chats = Auth::user()->chats()->with('challenge')->paginate();

      return view('admin.chats.index', compact('chats'));
   }

   public function messageEdit($id){
      $message = Message::find($id);
     return view ('admin.challenges.meus.edit-chat', compact('message'));
   }

   public function messageUpdate($id, Request $request){
    
      $message = Message::find($id);
     $challenge=$message->chat->challenge;
      $message->update(['content'=>$request->content]);
      return view('admin.challenges.meus.chat', compact('challenge'));
   }
   public function chatIniciar(Request $request, $id)
   {
      if (!$challenge = $this->repository->find($id)) {
         return redirect()->back();
      }
      $challenge = $this->repository->find($id);
      if ($challenge->chat()->first() == null) {
         $chat = $challenge->chat()->create(['status' => 'odilo']);
      } else {
         $chat = $challenge->chat()->first();
      }
      $challenge->update(['status' =>'RESPONDIDO' , 'answered_at' => now() ]);
      $chat->update(['status' => 'odilo']);
      $chat->messages()->create(['content' => $request->message, 'type' => '2']);

      //  $chat->notify(new ChatTelegramNotification());

      return redirect()->route('challenge.my');
   }

   
}
