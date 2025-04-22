@extends('layouts.app')

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            background-image: linear-gradient(
                rgba(0, 0, 0, 0.6),
                rgba(0, 0, 0, 0.6)
            ), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
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
            <div class="col-md-10 mb-4">
                <div class="card shadow-sm border-0 rounded-4 mt-5">
                    <div class="card-header bg-transparent border-bottom text-center">
                        <h3 class="fw-bold text-primary">{{ __('Cadastro') }}</h3>
                        <p class="text-muted small">Crie sua conta para acessar o sistema</p>
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Formulário de Cadastro -->
                        <form method="POST" action="{{ route('register.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Campo de Nome -->
                            <div class="mb-3">
                                <label for="nome" class="form-label fw-medium text-muted">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-user text-primary"></i></span>
                                    <input type="text"
                                           class="form-control form-control-lg border-start-0 @error('nome') is-invalid @enderror"
                                           id="nome" name="nome" value="{{ old('nome') }}" required autofocus
                                           placeholder="Ex.: João Silva">
                                </div>
                                @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium text-muted">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-envelope text-primary"></i></span>
                                    <input type="email"
                                           class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required
                                           placeholder="Ex.: joao.silva@email.com">
                                </div>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Telefone -->
                            <div class="mb-3">
                                <label for="telefone" class="form-label fw-medium text-muted">Telefone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-phone text-primary"></i></span>
                                    <input type="text"
                                           class="form-control form-control-lg border-start-0 @error('telefone') is-invalid @enderror"
                                           id="telefone" name="telefone" value="{{ old('telefone') }}" required
                                           placeholder="Ex.: (11) 98765-4321">
                                </div>
                                @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Data de Nascimento -->
                            <div class="mb-3">
                                <label for="data_nascimento" class="form-label fw-medium text-muted">Data de
                                    Nascimento</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-calendar text-primary"></i></span>
                                    <input type="date"
                                           class="form-control form-control-lg border-start-0 @error('data_nascimento') is-invalid @enderror"
                                           id="data_nascimento" name="data_nascimento"
                                           value="{{ old('data_nascimento') }}" required>
                                </div>
                                @error('data_nascimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Sexo -->
                            <div class="mb-3">
                                <label for="sexo" class="form-label fw-medium text-muted">Sexo</label>
                                <select class="form-select form-select-lg @error('sexo') is-invalid @enderror" id="sexo"
                                        name="sexo" required>
                                    <option value="" disabled selected>Selecione uma opção</option>
                                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>
                                        Masculino
                                    </option>
                                    <option value="feminino" {{ old('sexo') == 'feminino' ? 'selected' : '' }}>
                                        Feminino
                                    </option>
                                    <option value="outro" {{ old('sexo') == 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('sexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Tipo de Deficiência -->
                            <div class="mb-3">
                                <label for="disability_type" class="form-label fw-medium text-muted">Tipo de
                                    Deficiência</label>
                                <select
                                    class="form-select form-select-lg @error('disability_type') is-invalid @enderror"
                                    id="disability_type" name="disability_type" required>
                                    <option value="" disabled selected>Selecione uma opção</option>
                                    <option value="visual" {{ old('disability_type') == 'visual' ? 'selected' : '' }}>
                                        Visual
                                    </option>
                                    <option
                                        value="auditiva" {{ old('disability_type') == 'auditiva' ? 'selected' : '' }}>
                                        Auditiva
                                    </option>
                                    <option value="fisica" {{ old('disability_type') == 'fisica' ? 'selected' : '' }}>
                                        Física
                                    </option>
                                    <option
                                        value="intelectual" {{ old('disability_type') == 'intelectual' ? 'selected' : '' }}>
                                        Intelectual
                                    </option>
                                    <option value="nenhuma" {{ old('disability_type') == 'nenhuma' ? 'selected' : '' }}>
                                        Outros
                                    </option>
                                </select>
                                @error('disability_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Senha -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium text-muted">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-lock text-primary"></i></span>
                                    <input type="password"
                                           class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror"
                                           id="password" name="password" required placeholder="Mínimo de 8 caracteres">
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo de Confirmação de Senha -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-medium text-muted">Confirmar
                                    Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-lock text-primary"></i></span>
                                    <input type="password" class="form-control form-control-lg border-start-0"
                                           id="password_confirmation" name="password_confirmation" required
                                           placeholder="Repita sua senha">
                                </div>
                            </div>

                            <!-- Botão de Cadastrar -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill mt-3">
                                <i class="fas fa-user-plus me-2"></i> Cadastrar
                            </button>
                        </form>
                    </div>

                    <!-- Rodapé -->
                    <div class="card-footer bg-transparent border-top text-center py-3">
                        <p class="small mb-0 text-muted">
                            Já tem uma conta?
                            <a href="{{ route('login') }}" class="text-primary fw-medium text-decoration-none">
                                Entrar <i class="fas fa-sign-in-alt ms-1"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
