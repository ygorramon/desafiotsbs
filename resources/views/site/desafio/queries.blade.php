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
                            <a href="https://api.whatsapp.com/send?phone=5588996620215" target="_blank "
                                class="btn"> Suporte Técnico </a>
                        </div>
                    </div>
                    <div id="card-widgets">
                        <div class="row">
                            <div class="col s12">

                                <div id="bordered-table" class="card card card-default scrollspy">
                                    <div class="card-content">

                                        <h5 class="task-card-title mb-3 ">Central de Dúvidas - Odilo Queiroz </h5>
                                         <h5 class="task-card-title mb-3 ">{{$submodule->module->description}}</h5>
                                        <h6 class="task-card-title mb-3 ">{{$submodule->description}}</h5>
                                    

                                        <ul class="collapsible">
                                            @forelse($submodule->queries as $query)
                                          
                      <li>
                        <div class="collapsible-header">{{$query->title}}</div>
                        <div class="collapsible-body"> <textarea class="materialize-textarea" readonly>{{$query->response}}</textarea>
                        </div>
                      </li>
                                          
                                            @empty
                                            @endforelse
                                        </ul>
                                        @if(Auth::guard('clients')->user()->liberado!=1)
<div class="card-alert card purple lighten-5">
            <div class="card-content purple-text">
                Outra dúvida sobre {{$submodule->description}}?
              <a href="{{route('query.show')}}"  class="btn"> Faça sua pergunta Aqui! </a>
            </div>
          </div>
          @endif
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
  
  $(document).ready(function() {
    $('.collapsible').collapsible({
      accordion: true
    });
  });
</script>

@endsection
