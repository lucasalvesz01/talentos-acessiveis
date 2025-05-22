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
        .text-preto {
            color: black !important;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold">{{ __('Entrar') }}</h3>
                </div>
                <div class="card-body p-4">
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
                    <form method="POST" action="{{ route('login.store') }}" class="text-preto" >
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Digite seu email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Senha</label>
                            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Digite sua senha">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 ">
                            Entrar <i class="fas fa-sign-in-alt ms-2"></i>
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center py-3 text-preto">
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
