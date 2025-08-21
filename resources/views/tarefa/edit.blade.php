@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h3 class="mb-0 fw-bold">Editar Tarefa</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('tarefa.update', Crypt::encrypt($tarefa->id)) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="titulo" class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="titulo" id="titulo" required value="{{ old('titulo', $tarefa->titulo) }}" placeholder="Digite o título da tarefa">
                            </div>
                            <div class="mb-4">
                                <label for="descricao" class="form-label fw-semibold">Descrição</label>
                                <textarea class="form-control form-control-lg" name="descricao" id="descricao" rows="3" placeholder="Descreva a tarefa">{{ old('descricao', $tarefa->descricao) }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="data_limite" class="form-label fw-semibold">Data Limite</label>
                                <input type="date" class="form-control form-control-lg" name="data_limite" id="data_limite" value="{{ old('data_limite', $tarefa->data_limite ? \Carbon\Carbon::parse($tarefa->data_limite)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                    <i class="bi bi-save me-2"></i> Salvar Alterações
                                </button>
                            </div>
                        </form>
                        <div class="mb-4">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('tarefa.index') }}" class="text-decoration-none text-primary">
                        <i class="bi bi-arrow-left"></i> Voltar para lista de tarefas
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
