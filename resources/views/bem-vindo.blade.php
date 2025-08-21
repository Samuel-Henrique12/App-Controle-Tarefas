@extends('layouts.app')


@section('content')
    @auth
        <h1>Usuário Autenticado</h1>
        <p>ID {{ auth()->user()->id }}</p>
        <p>Nome: {{ auth()->user()->name }}</p>
        <p>Email: {{ auth()->user()->email }}</p>
    @endauth

    @guest
        <h1>Bem-vindo ao Sistema de Controle de Tarefas</h1>
        <p>Por favor, faça login ou registre-se para continuar.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Registrar</a
    @endguest

@endsection
