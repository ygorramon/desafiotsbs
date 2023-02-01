@extends('site.desafio.layouts.app')
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}" media="screen,projection" />
@stop



@section('content')
<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div id="card-widgets">
                    <div class="row">
                        <div class="col s12">
                        <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Informação</h4>
      <p>O número do Suporte Técnico do Desafio de 7 Dias mudou: </p>
      <p> 5588996620215</p>
      <a href="https://api.whatsapp.com/send?phone=5588996620215" target="_blank " class="btn"> Suporte Técnico </a>    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok</a>
    </div>
  </div>
-->

                            <ul id="task-card" class="collection with-header animate fadeLeft">
                                <li class="collection-header red">
                                    <h5 class="task-card-title mb-3">Meus Desafios</h5>

                                </li>
                                <table class="bordered">
                                    <thead><th>Desafio</th><th>Status</th><td>Ações</td></thead>
                                @forelse ($challenges as $key => $challenge)
                                <tr>
                                <td>{{$key+1}}</td><td>{{$challenge->status}}
                                      @if($challenge->status=='RESPONDIDO') <br> ( Chat até <b>{{\Carbon\Carbon::parse($challenge->answered_at)->addDays(59)->format('d/m/y')}} </b> )
                            <br><br>
                             ( Restam <b>{{\Carbon\Carbon::parse($challenge->answered_at)->addDays(59)->diffInDays(now())}}</b> Dias de Chat ) 
                             @endif
                                </td>
                                <td><a href="{{route('desafio.show',$challenge->id)}}" > <span class="task-cat red">Acessar</span></a><br><br>
                          
                            </td>
                                </tr>
                                @empty
                                </table>
                                <form action="{{route('desafio.store')}}" method="POST">
                                    @csrf
                                    <li class="collection-item dismissable">
                                        <button class="btn waves-effect waves-light " type="submit"> Inicie um novo desafio </submit>
                                </form>
                                </li>
                                @endforelse

                                @if(isset($latest_challenge) && $latest_challenge->status=='FINALIZADO')
                                <form action="{{route('desafio.store')}}" method="POST">
                                    @csrf
                                    <li class="collection-item dismissable">
                                        <button class="btn waves-effect waves-light " type="submit"> Inicie um novo desafio </submit>
                                    </li>
                                </form>
                                @endif


                            </ul>
                            <div class="card-alert card purple lighten-5">
            <div class="card-content purple-text">
              <a href="https://api.whatsapp.com/send?phone=5588996620215" target="_blank " class="btn"> Suporte Técnico </a>
            </div>
          </div>
                        </div>

                    </div>
                    
                </div>




                @endsection
            </div>
            
        </div>
        
    </div>
    
</div>


@section('js')

<script>
$(document).ready(function(){
    $('.modal').modal({
       
    });
    $('#modal1').modal('open');
  });
  </script>

@endsection