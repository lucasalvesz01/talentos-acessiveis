@extends('layouts.app')

@section('content')
<style>
    /* Estilo para o background ocupando toda a tela */
    body {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 100%;
        height: 100vh;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid #ddd;
    }
    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: scale(1.05);
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-4 mt-5">
                <!-- Cabeçalho -->
                <div class="card-header bg-transparent border-bottom text-center">
                    <h3 class="fw-bold text-primary">{{ __('Entrar') }}</h3>
                    <p class="text-muted small">Faça login para acessar sua conta</p>
                </div>
                <!-- Corpo do Cartão -->
                <div class="card-body p-4">

                    <!-- Mensagens de Erro -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulário de Login -->
                    <form method="POST" action="{{ route('login.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Campo de Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium text-muted">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-primary"></i></span>
                                <input type="email" class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Ex.: joao.silva@email.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo de Senha -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium text-muted">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-primary"></i></span>
                                <input type="password" class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Digite sua senha">
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botão de Login -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill mt-3">
                            <i class="fas fa-sign-in-alt me-2"></i> Entrar
                        </button>
                    </form>
                </div>
                <!-- Rodapé -->
                <div class="card-footer bg-transparent border-top text-center py-3">
                    <p class="small mb-0 text-muted">
                        Não tem uma conta? 
                        <a href="{{ route('register') }}" class="text-primary fw-medium text-decoration-none">
                            Registrar-se <i class="fas fa-user-plus ms-1"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection