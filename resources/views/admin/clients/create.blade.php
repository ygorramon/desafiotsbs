@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('clients.index') }}" class="active">Clientes</a></li>
</ol>

@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('clients.store') }}" class="form" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>* Email:</label>
                <input type="email" name="email" class="form-control" placeholder="Email:" value="{{ $client->email ?? old('email') }}">
            </div>
            <div class="form-group">
                <label>* Tempo de Expiração:</label>
                <select name="expire" class="form-control">
                    <option value="45">45 Dias</option>
                    <option value="60">60 Dias</option>
                    <option value="120">120 Dias</option>
                    <option value="180">180 Dias</option>
                    <option value="365">365 Dias</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-dark"> Enviar </button>
            </div>

        </form>
    </div>
</div>
@endsection