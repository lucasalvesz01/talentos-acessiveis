@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 mt-5">
                    <div class="card-header bg-transparent border-bottom text-center">
                        <h3 class="fw-bold text-primary">Currículo</h3>
                    </div>

                    <div class="card-body">

                        <!-- Mensagens de sucesso ou erro -->
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

                        <!-- Mostra o currículo se já existir -->
                        @if (Auth::user()->curriculum)
                            <div class="mb-3 text-center">
                                <p>Seu currículo foi enviado com sucesso!</p>
                                <a href="{{ route('curriculum.download') }}" class="btn btn-success w-100 mb-3">
                                    Baixar Currículo
                                </a>
                            </div>
                        @else
                            <p class="text-center mb-4">Você ainda não enviou um currículo.</p>
                        @endif

                        <!-- Botão para abrir o modal de upload -->
                        <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            Enviar Currículo
                        </button>

                        <!-- Botão para visualizar feeds -->
                        <a href="{{ route('feeds.index') }}" class="btn btn-outline-secondary w-100">
                            Visualizar Feeds
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Upload de Currículo -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Enviar Currículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('curriculum.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="curriculum" class="form-label">Escolha o arquivo do currículo (PDF, DOC, DOCX)</label>
                            <input type="file" class="form-control" id="curriculum" name="curriculum" accept=".pdf,.doc,.docx" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Enviar Currículo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection