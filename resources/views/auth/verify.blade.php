@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Valide o email') }}
                        </div>
                    @endif

                    Antes de utilizar os recursos da aplicação, valide seu email por meio do link de validação
                    Caso não tenha recebido, clique no link a seguir
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Clique aqui') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
