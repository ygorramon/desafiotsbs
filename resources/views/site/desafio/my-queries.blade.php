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
                      

                            <ul id="task-card" class="collection with-header animate fadeLeft">
                                <li class="collection-header red">
                                    <h5 class="task-card-title mb-3">Minhas Perguntas</h5>

                                </li>
                                <table class="bordered">
                                    <thead><th>Pergunta</th><th>Status</th><td>Ações</td></thead>
                                @forelse ($doubts as $key => $doubt)
                                <tr>
                                <td>{{$doubt->query}}</td><td>{{$doubt->status}}
                                      
                                </td>
                                <td>
                                <a href="{{route('my.query.show', $doubt->id)}}" > <span class="task-cat red">Visualizar</span></a>
                                </td>
                                </tr>
                                @empty
                                @endforelse

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