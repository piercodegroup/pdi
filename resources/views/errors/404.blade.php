@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1>404 - Página não encontrada</h1>
        <p>A página que você está tentando acessar não existe.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Voltar para o início</a>
    </div>
@endsection
