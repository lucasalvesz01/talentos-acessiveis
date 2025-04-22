@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 mt-5">
                    <div class="card-header bg-transparent border-bottom text-center">
                        <h3 class="fw-bold text-primary">Currículo Enviado</h3>
                    </div>

                    <div class="card-body">
                        @if (Auth::user()->curriculum)
                            <div class="mb-3">
                                <a href="{{ Storage::url(Auth::user()->curriculum) }}" target="_blank" class="btn btn-success">
                                    Baixar Currículo
                                </a>
                            </div>
                        @else
                            <p>Você ainda não enviou um currículo.</p>
                        @endif

                        <!-- Botão para abrir o modal de upload -->
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#uploadModal">Enviar Novo Currículo</button>
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
                            <label for="curriculum" class="form-label">Escolha o arquivo do currículo</label>
                            <input type="file" class="form-control" id="curriculum" name="curriculum" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
