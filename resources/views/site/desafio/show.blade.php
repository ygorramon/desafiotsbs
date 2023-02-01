@extends('site.desafio.layouts.app')
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')
<div class="row">
  <div class="col s12">
    <div class="container">
      <div class="section">
        <div class="card-alert">
            <div class="card-content purple-text">
              <a href="https://api.whatsapp.com/send?phone=5588996620215" target="_blank " class="btn"> Suporte Técnico </a>
            </div>
          </div>
        <div id="card-widgets">
          <div class="row">
            <div class="col s12">

              <div id="bordered-table" class="card card card-default scrollspy">
                <div class="card-content">
                  @if($challenge->status=='ENVIADO')
                  <div class="row">
                    <div class="col s12">
                      <h4 class="card-title">Seu Desafio foi Enviado! </h4>
                    </div>
                    <div class="col s12">
                      <h4 class="card-title">Em breve você receberá a análise! </h4>
                    </div>

                  </div>
                  @endif
                  @if($challenge->status=='ANALISE')
                  <div class="row">
                    <div class="col s12">
                      <h4 class="card-title">O Dr. Odilo está analisando seu Desafio! </h4>
                    </div>
                    <div class="col s12">
                      <h4 class="card-title">Em breve você receberá a análise! </h4>
                    </div>

                  </div>
                  @endif
                  @if($challenge->status=='FINALIZADO')
                  <div class="row">
                    <div class="col s12">
                      <h4 class="card-title">Análise do Seu Desafio (Clique em cada Passo abaixo) </h4>
                    </div>

                    <ul class="collapsible">
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 1</div>
                        <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo1}}</textarea>
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 2</div>
                        <div class="collapsible-body"><textarea class="materialize-textarea" readonly> {{$challenge->passo2}}</textarea></div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 3</div>
                        <div class="collapsible-body">
                          <ul class="collapsible">
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Despertar</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_despertar}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Rotina Alimentar</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_rotina_alimentar}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Rotina de Sonecas</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_rotina_sonecas}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Ambiente de Sonecas</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_ambiente_sonecas}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Sono Noturno</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_sono_noturno}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Ambiente do Sono Noturno</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_ambiente_noturno}}</textarea>
                              </div>
                            </li>
                        </div>

                      </li>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 4</div>
                        <div class="collapsible-body">
                          <ul class="collapsible">
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Associações da Soneca</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo4_associacoes_sonecas}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Associações do Sono Noturno</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo4_associacoes_noturno}}</textarea>
                              </div>
                            </li>
                          </ul>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Conclusão</div>
                        <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->conclusao}}</textarea>
                        </div>
                      </li>
                    </ul>
                    <ul class="collapsible">
                      <li>
                        <div class="collapsible-header"><i class="material-icons">message</i>Chat</div>
                        <div class="collapsible-body">
                         
                          @if($challenge->chat()->first()!=null)
                          @foreach($challenge->chat()->first()->messages as $message)
                          @if($message->type==1)
                          <label >Eu:</label>
                          <textarea class="materialize-textarea" readonly> {{$message->content}}</textarea>
                          @endif
                          @if($message->type==2)
                          <label >Dr. Odilo:</label>
                          <textarea class="materialize-textarea" readonly> {{$message->content}}</textarea>
                          @endif
                          @endforeach
                          

                         
                          
@endif
@endif
                  @if($challenge->status=='RESPONDIDO')
                  <div class="row">
                    <div class="col s12">
                      <h4 class="card-title">Análise do Seu Desafio (Clique em cada Passo abaixo) </h4>
                    </div>

                    <ul class="collapsible">
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 1</div>
                        <div class="collapsible-body"> <textarea class="materialize-textarea" readonly > {{$challenge->passo1}}</textarea>
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 2</div>
                        <div class="collapsible-body"><textarea class="materialize-textarea" readonly> {{$challenge->passo2}}</textarea></div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 3</div>
                        <div class="collapsible-body">
                          <ul class="collapsible">
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Despertar</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_despertar}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Rotina Alimentar</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_rotina_alimentar}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Rotina de Sonecas</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_rotina_sonecas}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Ambiente de Sonecas</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_ambiente_sonecas}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Sono Noturno</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_sono_noturno}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Ambiente do Sono Noturno</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo3_ambiente_noturno}}</textarea>
                              </div>
                            </li>
                        </div>

                      </li>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Passo 4</div>
                        <div class="collapsible-body">
                          <ul class="collapsible">
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Associações da Soneca</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo4_associacoes_sonecas}}</textarea>
                              </div>
                            </li>
                            <li>
                              <div class="collapsible-header"><i class="material-icons">place</i>Associações do Sono Noturno</div>
                              <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->passo4_associacoes_noturno}}</textarea>
                              </div>
                            </li>
                          </ul>
                      <li>
                        <div class="collapsible-header"><i class="material-icons">place</i>Conclusão</div>
                        <div class="collapsible-body"> <textarea class="materialize-textarea" readonly> {{$challenge->conclusao}}</textarea>
                        </div>
                      </li>
                    </ul>
@if ($challenge->status=='RESPONDIDO')
                    <div class="card">
                    <div class="card-content">
                    <span class="card-title"> INFORMAÇÕES SOBRE O CHAT</span>
                       
                      
      
      <p> O CHAT abaixo ficará disponível por 30 Dias após a resposta do seu desafio!</p>
      <p> Você só pode colocar uma mensagem até o dr Odilo responder.</p>
      <p> Esse CHAT finalizará no dia {{\Carbon\Carbon::parse($challenge->answered_at)->addDays(59)->format('d/m/y')}} </p>
      <p> Restam {{\Carbon\Carbon::parse($challenge->answered_at)->addDays(59)->diffInDays(now())}}</b> Dias de Chat </p>
      <p> Após esse prazo, você poderá realizar um novo desafio </p>
      </div>
    </div>
@endif

                    <ul class="collapsible">
                      <li>
                        <div class="collapsible-header"><i class="material-icons">message</i>Chat  </div>
                        <div class="collapsible-body">
                          @if($challenge->chat()->first()==null)
                          Envie uma mensagem ao Dr. Odilo Queiroz sobre seu desafio!
                          <form action="{{route('challenge.chat.store', $challenge->id)}}" method="POST">
                            @csrf
                            <label >Responder:</label>
                            <textarea class="materialize-textarea" name="message"></textarea>
                            <button class="btn btn-primary">Enviar </button>
                          </form>
                          @endif
                          @if($challenge->chat()->first()!=null)
                          @if($challenge->chat()->first()->status=='mae')
                          @foreach($challenge->chat()->first()->messages as $message)
                          @if($message->type==1)
                          <label >Eu:</label>
                          <textarea class="materialize-textarea" readonly> {{$message->content}}</textarea>
                          
                          @endif
                          @if($message->type==2)
                          <label >Dr. Odilo:</label>
                          <textarea class="materialize-textarea" readonly> {{$message->content}}</textarea>
                          
                          @endif
                          @endforeach
                         
                          Aguarde o retorno do Dr. Odilo!
<br>
                           <a class="btn btn-primary"href="{{route('client.message.edit',$challenge->chat()->first()->messages->last()->id)}}">Editar última mensagem</a><br>
                          @endif

                         
                          @if($challenge->chat()->first()->status=='odilo')
                          @foreach($challenge->chat()->first()->messages as $message)
                          @if($message->type==1)
                          <label >Eu:</label>
                          <textarea class="materialize-textarea" readonly> {{$message->content}}</textarea>
                          @endif
                          @if($message->type==2)
                          <label >Dr. Odilo:</label>
                          <textarea class="materialize-textarea" readonly> {{$message->content}}</textarea>
                          @endif
                          @endforeach
                          <form action="{{route('challenge.chat.store', $challenge->id)}}" method="POST">
                            @csrf
                            <label >Responder:</label>
                            <textarea class="materialize-textarea" name="message" required></textarea>
                            <button class="btn btn-primary">Enviar </button>
                          </form>
                          @endif
@endif
                        </div>
                      </li>

                    </ul>

                  </div>
                  
                  @endif
@if($challenge->client->liberado==1)
 @if($challenge->status=='INICIADO')
                  <h4 class="card-title">Análise Diária</h4>

                  <div class="row">
                    <div class="col s12">
                    </div>
                    <div class="col s12">
                      <table class="bordered">
                        <thead>
                          <tr>
                            <th data-field="dia">Dia / Formulário</th>
                            <th data-field="dia">Preenchido?</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @if(!isset($challenge->analyzes()->where('day','1')->first()->day))
                            <td><a href="{{route('analyze.create',[$challenge->id,1])}}" class="btn waves-effect waves-light red "> Dia 1 </a>
                    </div>
                    @else
                    <td><a href="{{route('analyze.edit',[$challenge->id,1])}}" class="btn waves-effect waves-light red "> Dia 1 </a>
                  </div>
                  @endif

                  @if(isset($challenge->analyzes()->where('day','1')->first()->day))
                  <td><i class="material-icons">check </i>  {{date_format(new DateTime($challenge->analyzes()->where('day','1')->first()->date),'d/m/Y') }}
                  </td>
                  @else
                  <td>NÃO</td>

                  @endif
                  </tr>
                  
                  @if(isset($challenge->analyzes()->where('day','1')->first()->day))
              <tr>
                @if(!isset($challenge->analyzes()->where('day','2')->first()->day))

                <td><a href="{{route('analyze.create',[$challenge->id,2])}}" class="btn waves-effect waves-light red "> Dia 2 </a>
            </div>
            @else
            <td><a href="{{route('analyze.edit',[$challenge->id,2])}}" class="btn waves-effect waves-light red "> Dia 2 </a>
          </div>
          @endif

        
          @if(isset($challenge->analyzes()->where('day','2')->first()->day))
          <td> <i class="material-icons">check</i> {{date_format(new DateTime($challenge->analyzes()->where('day','2')->first()->date),'d/m/Y') }} </td>
          @else
          <td>NÃO</td>

          @endif
          @else
          
          @endif
          </tr>
        


              @if(isset($challenge->analyzes()->where('day','2')->first()->day))
              <tr>
                @if(!isset($challenge->analyzes()->where('day','3')->first()->day))

                <td><a href="{{route('analyze.create',[$challenge->id,3])}}" class="btn waves-effect waves-light red "> Dia 3 </a>
            </div>
            @else
            <td><a href="{{route('analyze.edit',[$challenge->id,3])}}" class="btn waves-effect waves-light red "> Dia 3  </a>
          </div>
          @endif


          @if(isset($challenge->analyzes()->where('day','3')->first()->day))
          <td> <i class="material-icons">check</i> {{date_format(new DateTime($challenge->analyzes()->where('day','3')->first()->date),'d/m/Y') }} </td>
          @else
          <td>NÃO</td>

          @endif
          @else
          
          @endif
          </tr>
         

          @if(isset($challenge->analyzes()->where('day','3')->first()->day))
          <tr>
            @if(!isset($challenge->analyzes()->where('day','4')->first()->day))

            <td><a href="{{route('analyze.create',[$challenge->id,4])}}" class="btn waves-effect waves-light red "> Dia 4 </a>
        </div>
        @else
        <td><a href="{{route('analyze.edit',[$challenge->id,4])}}" class="btn waves-effect waves-light red "> Dia 4 </a>
      </div>
      @endif

      @if(isset($challenge->analyzes()->where('day','4')->first()->day))
      <td> <i class="material-icons">check</i> {{date_format(new DateTime($challenge->analyzes()->where('day','4')->first()->date),'d/m/Y') }}
      </td>
      @else
      <td>NÃO</td>

      @endif
      @else
     
      @endif
      </tr>
      

      @if(isset($challenge->analyzes()->where('day','4')->first()->day))
      <tr>
       

        @if(!isset($challenge->analyzes()->where('day','5')->first()->day))

        <td><a href="{{route('analyze.create',[$challenge->id,5])}}" class="btn waves-effect waves-light red "> Dia 5 </a>
    </div>
    @else
    <td><a href="{{route('analyze.edit',[$challenge->id,5])}}" class="btn waves-effect waves-light red "> Dia 5 </a>
  </div>
  @endif


  @if(isset($challenge->analyzes()->where('day','5')->first()->day))
  <td> <i class="material-icons">check</i> {{date_format(new DateTime($challenge->analyzes()->where('day','5')->first()->date),'d/m/Y') }}
    
  </td>
  @else
  <td>NÃO</td>

  @endif
  @else
  
  @endif
  </tr>
 

  @if(isset($challenge->analyzes()->where('day','5')->first()->day))
  <tr>
    @if(!isset($challenge->analyzes()->where('day','6')->first()->day))

    <td><a href="{{route('analyze.create',[$challenge->id,6])}}" class="btn waves-effect waves-light red "> Dia 6 </a>
</div>
@else
<td><a href="{{route('analyze.edit',[$challenge->id,6])}}" class="btn waves-effect waves-light red "> Dia 6 </a> </div>
  @endif
  @if(isset($challenge->analyzes()->where('day','6')->first()->day))
<td> <i class="material-icons">check</i> {{date_format(new DateTime($challenge->analyzes()->where('day','6')->first()->date),'d/m/Y') }} </td>
@else
<td>NÃO</td>

@endif
@else

@endif
</tr>


@if(isset($challenge->analyzes()->where('day','6')->first()->day))
<tr>

  @if(!isset($challenge->analyzes()->where('day','7')->first()->day))

  <td><a href="{{route('analyze.create',[$challenge->id,7])}}" class="btn waves-effect waves-light red "> Dia 7 </a>
    </div>
    @else
  <td><a href="{{route('analyze.edit',[$challenge->id,7])}}" class="btn waves-effect waves-light red "> Dia 7  </a> </div>
    @endif
    @if(isset($challenge->analyzes()->where('day','7')->first()->day))
  <td> <i class="material-icons">check</i> {{date_format(new DateTime($challenge->analyzes()->where('day','7')->first()->date),'d/m/Y') }} </td>
  @else
  <td>NÃO</td>

  @endif
  @else
  
  @endif
</tr>


@if(isset($challenge->analyzes()->where('day','7')->first()->day))
<tr>

  @if(!isset($challenge->form()->first()->id))

  <td><a href="{{route('analyze.form',$challenge->id)}}" class="btn waves-effect waves-light red "> Formulário Final </a></td>

  @else
  <td><a href="{{route('analyze.form.edit',$challenge->id)}}" class="btn waves-effect waves-light red "> Formulário Final </a> </div>
    @endif


    @if(isset($challenge->form()->first()->id))
  <td> <i class="material-icons">check</i>
    
  </td>
  @else
  <td>NÃO</td>

  @endif
  @else
  
  @endif
</tr>
<tr>
  <td>
  <a href="{{route('client.profile.edit')}}" class="btn waves-effect waves-light red "> Meus Dados </a>
  </td>
  <td></td>
</tr>


@if(isset($challenge->form()->first()->id))
<tr>
  <td>
    <form action="{{route('desafio.update',$challenge->id)}}" method="POST">
      @csrf
      {{ method_field('PUT') }}
      <button class="btn">Enviar Desafio</button>
  </td>
  <td></td>
</tr>



@endif

</tbody>
</table>
</div>
</div>

@endif
@else
                  @if($challenge->status=='INICIADO')
                  <h4 class="card-title">Análise Diária</h4>

                  <div class="row">
                    <div class="col s12">
                    </div>
                    <div class="col s12">
                      <table class="bordered">
                        <thead>
                          <tr>
                            <th data-field="dia">Dia / Formulário</th>
                            <th data-field="dia">Preenchido?</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @if(!isset($challenge->analyzes()->where('day','1')->first()->day))
                            <td><a href="{{route('analyze.create',[$challenge->id,1])}}" class="btn waves-effect waves-light red "> Dia 1 </a>
                    </div>
                    @else
                    <td><a href="{{route('analyze.edit',[$challenge->id,1])}}" class="btn waves-effect waves-light red "> Dia 1 </a>
                  </div>
                  @endif

                  @if(isset($challenge->analyzes()->where('day','1')->first()->day))
                  <td><i class="material-icons">check</i>
                    {{date_format($challenge->analyzes()->where('day','1')->first()->created_at,'d/m/Y') }}
                  </td>
                  @else
                  <td>NÃO</td>

                  @endif
                  </tr>
                  
                  @if(isset($challenge->analyzes()->where('day','1')->first()->day))
              <tr>
                @if(date_format(now(),'Y-m-d')>=date_format($challenge->analyzes()->where('day','1')->first()->created_at->addDays(1),'Y-m-d'))
                @if(!isset($challenge->analyzes()->where('day','2')->first()->day))

                <td><a href="{{route('analyze.create',[$challenge->id,2])}}" class="btn waves-effect waves-light red "> Dia 2 </a>
            </div>
            @else
            <td><a href="{{route('analyze.edit',[$challenge->id,2])}}" class="btn waves-effect waves-light red "> Dia 2 </a>
          </div>
          @endif

        
          @if(isset($challenge->analyzes()->where('day','2')->first()->day))
          <td> <i class="material-icons">check</i> {{date_format($challenge->analyzes()->where('day','2')->first()->created_at,'d/m/Y') }} </td>
          @else
          <td>NÃO</td>

          @endif
          @else
          <td>Dia 2</td>
          <td>Disponível em {{date_format($challenge->analyzes()->where('day','1')->first()->created_at->addDays(1),'d/m/Y')}}</td>

          @endif
          </tr>
          @endif


              @if(isset($challenge->analyzes()->where('day','2')->first()->day))
              <tr>
                @if(date_format(now(),'Y-m-d')>=date_format($challenge->analyzes()->where('day','2')->first()->created_at->addDays(1),'Y-m-d'))
                @if(!isset($challenge->analyzes()->where('day','3')->first()->day))

                <td><a href="{{route('analyze.create',[$challenge->id,3])}}" class="btn waves-effect waves-light red "> Dia 3 </a>
            </div>
            @else
            <td><a href="{{route('analyze.edit',[$challenge->id,3])}}" class="btn waves-effect waves-light red "> Dia 3 </a>
          </div>
          @endif


          @if(isset($challenge->analyzes()->where('day','3')->first()->day))
          <td> <i class="material-icons">check</i> {{date_format($challenge->analyzes()->where('day','3')->first()->created_at,'d/m/Y') }} </td>
          @else
          <td>NÃO</td>

          @endif
          @else
          <td>Dia 3</td>
          <td>Disponível em {{date_format($challenge->analyzes()->where('day','2')->first()->created_at->addDays(1),'d/m/Y')}}</td>

          @endif
          </tr>
          @endif

          @if(isset($challenge->analyzes()->where('day','3')->first()->day))
          <tr>
            @if(date_format(now(),'Y-m-d')>=date_format($challenge->analyzes()->where('day','3')->first()->created_at->addDays(1),'Y-m-d'))
            @if(!isset($challenge->analyzes()->where('day','4')->first()->day))

            <td><a href="{{route('analyze.create',[$challenge->id,4])}}" class="btn waves-effect waves-light red "> Dia 4 </a>
        </div>
        @else
        <td><a href="{{route('analyze.edit',[$challenge->id,4])}}" class="btn waves-effect waves-light red "> Dia 4 </a>
      </div>
      @endif

      @if(isset($challenge->analyzes()->where('day','4')->first()->day))
      <td> <i class="material-icons">check</i>
        {{date_format($challenge->analyzes()->where('day','4')->first()->created_at,'d/m/Y') }}
      </td>
      @else
      <td>NÃO</td>

      @endif
      @else
      <td>Dia 4</td>
      <td>Disponível em {{date_format($challenge->analyzes()->where('day','3')->first()->created_at->addDays(1),'d/m/Y')}}</td>

      @endif
      </tr>
      @endif

      @if(isset($challenge->analyzes()->where('day','4')->first()->day))
      <tr>
        @if(date_format(now(),'Y-m-d')>=date_format($challenge->analyzes()->where('day','4')->first()->created_at->addDays(1),'Y-m-d'))

        @if(!isset($challenge->analyzes()->where('day','5')->first()->day))

        <td><a href="{{route('analyze.create',[$challenge->id,5])}}" class="btn waves-effect waves-light red "> Dia 5 </a>
    </div>
    @else
    <td><a href="{{route('analyze.edit',[$challenge->id,5])}}" class="btn waves-effect waves-light red "> Dia 5 </a>
  </div>
  @endif


  @if(isset($challenge->analyzes()->where('day','5')->first()->day))
  <td> <i class="material-icons">check</i>
    {{date_format($challenge->analyzes()->where('day','5')->first()->created_at,'d/m/Y') }}
  </td>
  @else
  <td>NÃO</td>

  @endif
  @else
  <td>Dia 5</td>
  <td>Disponível em {{date_format($challenge->analyzes()->where('day','4')->first()->created_at->addDays(1),'d/m/Y')}}</td>

  @endif
  </tr>
  @endif

  @if(isset($challenge->analyzes()->where('day','5')->first()->day))
  <tr>
    @if(date_format(now(),'Y-m-d')>=date_format($challenge->analyzes()->where('day','5')->first()->created_at->addDays(1),'Y-m-d'))
    @if(!isset($challenge->analyzes()->where('day','6')->first()->day))

    <td><a href="{{route('analyze.create',[$challenge->id,6])}}" class="btn waves-effect waves-light red "> Dia 6 </a>
</div>
@else
<td><a href="{{route('analyze.edit',[$challenge->id,6])}}" class="btn waves-effect waves-light red "> Dia 6 </a> </div>
  @endif
  @if(isset($challenge->analyzes()->where('day','6')->first()->day))
<td> <i class="material-icons">check</i> {{date_format($challenge->analyzes()->where('day','6')->first()->created_at,'d/m/Y') }} </td>
@else
<td>NÃO</td>

@endif
@else
<td>Dia 6</td>
<td>Disponível em {{date_format($challenge->analyzes()->where('day','5')->first()->created_at->addDays(1),'d/m/Y')}}</td>

@endif
</tr>
@endif

@if(isset($challenge->analyzes()->where('day','6')->first()->day))
<tr>
  @if(date_format(now(),'Y-m-d')>=date_format($challenge->analyzes()->where('day','6')->first()->created_at->addDays(1),'Y-m-d'))

  @if(!isset($challenge->analyzes()->where('day','7')->first()->day))

  <td><a href="{{route('analyze.create',[$challenge->id,7])}}" class="btn waves-effect waves-light red "> Dia 7 </a>
    </div>
    @else
  <td><a href="{{route('analyze.edit',[$challenge->id,7])}}" class="btn waves-effect waves-light red "> Dia 7 </a> </div>
    @endif
    @if(isset($challenge->analyzes()->where('day','7')->first()->day))
  <td> <i class="material-icons">check</i> {{date_format($challenge->analyzes()->where('day','7')->first()->created_at,'d/m/Y') }} </td>
  @else
  <td>NÃO</td>

  @endif
  @else
  <td>Dia 7</td>
  <td>Disponível em {{date_format($challenge->analyzes()->where('day','6')->first()->created_at->addDays(1),'d/m/Y')}}</td>

  @endif
</tr>
@endif

@if(isset($challenge->analyzes()->where('day','7')->first()->day))
<tr>
  @if(date_format(now(),'Y-m-d')>=date_format($challenge->analyzes()->where('day','7')->first()->created_at->addDays(1),'Y-m-d'))

  @if(!isset($challenge->form()->first()->id))

  <td><a href="{{route('analyze.form',$challenge->id)}}" class="btn waves-effect waves-light red "> Formulário Final </a></td>

  @else
  <td><a href="{{route('analyze.form.edit',$challenge->id)}}" class="btn waves-effect waves-light red "> Formulário Final </a> </div>
    @endif


    @if(isset($challenge->form()->first()->id))
  <td> <i class="material-icons">check</i>
    {{date_format($challenge->form()->first()->created_at,'d/m/Y') }}
  </td>
  @else
  <td>NÃO</td>

  @endif
  @else
  <td>Formulário Final</td>
  <td>Disponível em {{date_format($challenge->analyzes()->where('day','7')->first()->created_at->addDays(1),'d/m/Y')}}</td>

  @endif
</tr>
<tr>
  <td>
  <a href="{{route('client.profile.edit')}}" class="btn waves-effect waves-light red "> Atualize seus Dados </a>
  </td>
  <td></td>
</tr>
@endif

@if(isset($challenge->form()->first()->id))
<tr>
  <td>
    <form action="{{route('desafio.update',$challenge->id)}}" method="POST">
      @csrf
      {{ method_field('PUT') }}
      <button class="btn">Enviar Desafio</button>
  </td>
  <td></td>
</tr>



@endif

</tbody>
</table>
</div>
</div>

@endif

@endif
</div>
</div>

</div>

</div>
</div>
@if($challenge->client->liberado!=1)
 <div id="card-widgets" class="card">
          <div class="row">
            <div class="col s12">
            <div class="card-alert">
            <div class="card-content">
              
              <a href="{{route('query.show')}}"  class="btn"> Faça sua pergunta Aqui! </a>
            </div>
          </div>
            </div>
          </div>
 </div>
@endif


@endsection
</div>
</div>
</div>
</div>

@section('js')
<script>
  @if(session('sucesso'))
  M.toast({
    html: '{{session('sucesso')}}'
  })
  @endif
  $(document).ready(function() {
    $('.collapsible').collapsible({
      accordion: true
    });
  });
</script>

@endsection