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
                                class="btn">Suporte Técnico </a>
                        </div>
                    </div>
                    <div id="card-widgets">
                        <div class="row">
                            <div class="col s12">

                                <div id="bordered-table" class="card card card-default scrollspy">
                                    <div class="card-content">

                                        <h5 class="task-card-title mb-3 ">Central de Dúvidas - Odilo Queiroz </h5>
                                        <h5 class="task-card-title mb-3 ">{{$module->description}}</h5>

                                        <ul class="collection">
                                            @forelse($module->submodules as $submodule)
                                            <li class="collection-item avatar">
                                                <a href="{{route('doubtCenterSubModule.index',$submodule->id)}}">
                                                <i class="material-icons circle red">assignment_turned_in</i>
                                                <span class="title">{{$submodule->description}}</span>
                                                 </a> 
                                              
                                            </li>
                                          
                                            @empty
                                            @endforelse
                                        </ul>

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
