@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('clients.index') }}" class="active">Clients</a></li>
</ol>

<h1>Clientes <a href="{{ route('clients.create') }}" class="btn btn-dark">Adicionar</a></h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <form action="{{route('clients.search')}}" method="POST" class="form form-inline">
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
                    <th>E-mail</th>
                    <th>Terapeuta</th>
                    <th>Ativo</th>
                    <th>Expira</th>
                    <th width="270">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                     <td>{{ $client->user->name ?? '' }}</td>
                    @if($client->active==0)
                    <td><span class="badge badge-danger right">Não</span></td>
                    @endif

                    @if($client->active==1)
                    <td><span class="badge badge-success right">Sim</span></td>
                    @endif

                    @if (\Carbon\Carbon::createFromFormat('Y-m-d',$client->expireAt)->isFuture()
                    || \Carbon\Carbon::createFromFormat('Y-m-d',$client->expireAt)->isCurrentDay())
                    <td><span class="badge badge-success right">{{formatDateAndTime($client->expireAt, 'd/m/Y')}}</span></td>
                    @else
                    <td><span class="badge badge-danger right">{{ formatDateAndTime($client->expireAt, 'd/m/Y')}} </span></td>
                    @endif

                    <td style="width=10px;">
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-info">Edit</a>
                        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-warning">VER</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        @if (isset($filters))
        {!! $clients->appends($filters)->links() !!}
        @else
        {!! $clients->links() !!}
        @endif
    </div>
</div>
@stop