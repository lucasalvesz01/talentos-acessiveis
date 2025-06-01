@extends('layouts.app')

@section('content')
    <style>
        .card {
            transition: all 0.3s ease;
            transform-origin: center;
            backface-visibility: hidden;
            will-change: transform, box-shadow;
            border: 1px solid rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        @media (hover: hover) and (pointer: fine) {
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
                border-color: rgba(0, 0, 0, 0.1);
                z-index: 5;
            }
        }

        .card-img-container {
            height: 220px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img {
            transform: scale(1.03);
        }

        .placeholder-content {
            text-align: center;
            padding: 1rem;
        }

        .badge-custom {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .linkedin-link {
            display: inline-block;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: middle;
        }
        .card-img-container {
            height: 220px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative; /* Adicionado para melhor controle */
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Alterado de 'contain' para 'cover' para preencher o container */
            transition: transform 0.3s ease;
            position: absolute; /* Garante que a imagem ocupe todo o espaço */
        }

        /* Se você preferir manter a proporção sem cortar a imagem, use esta versão alternativa: */
        /*
        .card-img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        */

        .placeholder-content {
            text-align: center;
            padding: 1rem;
            z-index: 1; /* Garante que fique acima da imagem se houver */
            position: relative;
        }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary mb-3">Feed de Currículos</h2>

            <!-- Filtros -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('feeds.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="interest_area" class="form-label">Área de Interesse</label>
                                <select class="form-select" id="interest_area" name="interest_area">
                                    <option value="all">Todas áreas</option>
                                    @foreach($interestAreas as $area)
                                        <option value="{{ $area }}" {{ request('interest_area') == $area ? 'selected' : '' }}>
                                            {{ $area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="disability_type" class="form-label">Tipo de Deficiência</label>
                                <select class="form-select" id="disability_type" name="disability_type">
                                    <option value="all">Todos os tipos</option>
                                    @foreach($disabilityTypes as $type)
                                        <option value="{{ $type }}" {{ request('disability_type') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="work_availability" class="form-label">Disponibilidade</label>
                                <select class="form-select" id="work_availability" name="work_availability">
                                    <option value="all">Todas</option>
                                    @foreach($availabilities as $availability)
                                        <option value="{{ $availability }}" {{ request('work_availability') == $availability ? 'selected' : '' }}>
                                            {{ ucfirst($availability) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-funnel me-1"></i> Filtrar
                                </button>
                                <a href="{{ route('feeds.index') }}" class="btn btn-outline-secondary">
                                    Limpar Filtros
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($users->isEmpty())
            <div class="text-center text-muted py-4">
                <i class="bi bi-file-earmark-text fs-1"></i>
                <p class="fs-5 mt-2">Nenhum currículo encontrado com esses filtros.</p>
            </div>
        @else
            <div class="row g-6">
                @foreach ($users as $user)
                    <div class="col-md-4 mb-4 d-flex w-100">
                        <div class="card shadow border-0 rounded-4">
                            <!-- Imagem do currículo -->
                            <div class="card-img-container">
                                @php
                                    $imageName = pathinfo($user->curriculum, PATHINFO_FILENAME) . '.jpg';
                                    $imagePath = asset('/storage/curriculums/thumbnails/' . $imageName);
                                    $thumbnailExists = file_exists(public_path('/storage/curriculums/thumbnails/' . $imageName));
                                @endphp

                                @if($thumbnailExists)
                                    <img src="{{ $imagePath }}"
                                         alt="Currículo de {{ $user->name }}"
                                         class="card-img"
                                         loading="lazy"
                                         onerror="this.style.display='none';">
                                @endif

                                @if(!$thumbnailExists)
                                    <div class="placeholder-content text-muted">
                                        <i class="bi bi-file-earmark-pdf fs-1 text-primary opacity-75"></i>
                                        <h6 class="mt-2 mb-1">Currículo PDF</h6>
                                        <small>{{ $user->name }}</small>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary mb-3">{{ $user->name }}</h5>

                                <ul class="list-unstyled mb-3">
                                    <li class="mb-2"><strong>Email:</strong> {{ $user->email }}</li>
                                    <li class="mb-2"><strong>Sexo:</strong> {{ ucfirst($user->sexo) ?? 'Não informado' }}</li>
                                    <li class="mb-2"><strong>Deficiência:</strong> {{ ucfirst($user->disability_type) ?? 'Não informado' }}</li>

                                    <li class="mb-2">
                                        <strong>LinkedIn:</strong>
                                        @if($user->linkedin)
                                            <a href="{{ $user->linkedin }}" target="_blank" class="linkedin-link" rel="noopener noreferrer">
                                                {{ parse_url($user->linkedin, PHP_URL_HOST) }}
                                            </a>
                                        @else
                                            Não informado
                                        @endif
                                    </li>
                                </ul>

                                <div class="mt-auto">
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-primary-subtle text-primary-emphasis badge-custom">
                                        {{ $user->interest_area ?? 'Área não informada' }}
                                    </span>
                                        <span class="badge bg-primary-subtle text-primary-emphasis badge-custom">
                                        {{ ucfirst($user->work_availability) ?? 'Não informado' }}
                                    </span>
                                    </div>

                                    <div class="text-end">
                                        <a href="{{ route('curriculum.download', ['id' => $user->id]) }}"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-download me-1"></i> Baixar Currículo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($users->hasPages())
                <div class="mt-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Submit automático dos filtros
                const filterForm = document.querySelector('form[method="GET"]');
                const selects = filterForm.querySelectorAll('select');

                selects.forEach(select => {
                    select.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });

                // Tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    @endpush
@endsection
