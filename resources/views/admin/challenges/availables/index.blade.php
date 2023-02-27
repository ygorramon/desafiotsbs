@extends('adminlte::page')

@section('title', 'Desafios disponiveis')

@section('content_header')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('challenge.availables') }}" class="active">Desafios Diponíveis</a></li>
</ol>

@stop

@section('content')
<div class="card">
    <div class="card-header">
        <form action="#" method="POST" class="form form-inline">
            @csrf
            <input type="text" name="filter" placeholder="Filtrar:" class="form-control" value="{{ $filters['filter'] ?? '' }}">
            <button type="submit" class="btn btn-dark">Filtrar</button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Nome da Mãe</th>
                    <th>Nome do Bebê</th>
                     <th>Terapeuta</th>
                    <th>Bônus</th>
                    <th>Data de Envio</th>
                    <th> Outros desafios </th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($challenges as $challenge)
                <tr>
                     <td>{{ $challenge->client->name }} <br>({{ $challenge->client->email}})</td>
                    <td>{{ $challenge->client->nameBaby }}</td>
                   <td>{{ $challenge->client->user->name ?? '' }}</td>

                    <td> @if($challenge->client->bonus=='1')
                    <span class="badge bg-green">   SIM </span>
                    @else <span class="badge bg-red">   NÃO </span> @endif
                    </td>
                    <td> {{formatDateAndTimeHours($challenge->sended_at)}}</td>
                    <td> 
                    <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false"> <span class="badge bg-teal">{{$challenge->client->challenges()->count()}}</span>
                  
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                    @foreach($challenge->client->challenges()->get() as $challenge)      
                      <a class="dropdown-item" target="_blank" href="{{route('challenge.meus.respostas', $challenge->id)}}">{{formatDateAndTimeHours($challenge->sended_at)}} -  {{!empty($challenge->user) ? $challenge->user->name:''}}</a>                  
                      @endforeach
                    </div>
                  </div>                  
                    </td>
                    <td>

                        <a href="{{route('challenge.availables.show', $challenge->id)}}" class="btn btn-warning">VER</a>
                        <form action="{{route('challenge.get',$challenge->id )}} "  method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <button class="btn btn-primary">Pegar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        @if (isset($filters))
        {!! $challenges->appends($filters)->links() !!}
        @else
        {!! $challenges->links() !!}
        @endif
    </div>
</div>
@stop