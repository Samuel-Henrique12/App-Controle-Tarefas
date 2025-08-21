@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">{{ __('Acesso Negado') }}</div>

                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            {{ __('Você não tem permissão para acessar esta página.') }}
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-secondary">Voltar para o Início</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
