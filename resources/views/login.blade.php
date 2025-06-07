@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold">{{ __('Entrar') }}</h3>
                </div>
                <div class="card-body p-4">

                    <!-- Mensagens de Erro -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulário de Login -->
                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf

                        <!-- Campo de Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Digite seu email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo de Senha -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Senha</label>
                            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Digite sua senha">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botão de Entrar -->
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Entrar <i class="fas fa-sign-in-alt ms-2"></i>
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <p class="small mb-0">
                        Não tem uma conta? 
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">
                            Cadastrar
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection