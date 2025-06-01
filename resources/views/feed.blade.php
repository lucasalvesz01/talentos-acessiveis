@extends('layouts.app')

@section('content')
    <style>
        .card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-origin: center;
            backface-visibility: hidden;
            will-change: transform, box-shadow;
        }

        /*.card:hover {*/
        /*    transform: translateY(-8px) scale(1.02);*/
        /*    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;*/
        /*    z-index: 10;*/
        /*}*/

         Efeito adicional para dispositivos com hover (não touch)
        @media (hover: hover) and (pointer: fine) {
            .card {
                transition: all 0.3s ease-out;
            }

            .card:hover {
                transform: translateY(-6px) scale(1.015);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12) !important;
            }
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            border-color: rgba(0, 0, 0, 0.1);
        }

        .curriculum-thumbnail {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .curriculum-thumbnail:hover {
            transform: translateY(-2px);
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
        }

        .image-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .curriculum-image {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .curriculum-image.loaded {
            opacity: 1;
        }

        .curriculum-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            background-color: rgba(248, 249, 250, 0.8);
        }

        .curriculum-placeholder.active {
            opacity: 1;
        }

        .placeholder-content {
            max-width: 80%;
        }

        .card-img-top-container {
            position: relative;
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }


        .card:hover .card-img-top {
            transform: scale(1.03);
        }


        .image-error + div {
            display: flex !important;
        }
    </style>


    <div class="container py-5">
        <div class="text-center mb-5">
            <h3 class="fw-bold text-primary">feed de Currículos</h3>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('feeds.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="interest_area" class="form-label">Área de Interesse</label>
                                <select class="form-select" id="interest_area" name="interest_area">
                                    <option value="all">Todas áreas</option>
                                    @foreach($interestAreas as $area)
                                        <option
                                            value="{{ $area }}" {{ request('interest_area') == $area ? 'selected' : '' }}>
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
                                        <option
                                            value="{{ $type }}" {{ request('disability_type') == $type ? 'selected' : '' }}>
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
                                        <option
                                            value="{{ $availability }}" {{ request('work_availability') == $availability ? 'selected' : '' }}>
                                            {{ ucfirst($availability) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-funnel"></i> Filtrar
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
            <div class="text-center text-muted">
                <p>Nenhum currículo foi enviado ainda.</p>
            </div>
        @else
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-md-4 mb-4 d-flex w-50 ">
                        <div class="card-img-top h-100 shadow border-0 rounded-4">
                            @php
                                $imageName = pathinfo($user->curriculum, PATHINFO_FILENAME) . '.jpg';
                                $imagePath = asset('/storage/curriculums/thumbnails/' . $imageName);
                            @endphp

                            <div class="curriculum-thumbnail position-relative bg-light rounded-top card-img-top-container bg-light"
                                 style="height: 220px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">

                                <!-- Imagem ou placeholder -->
                                @php
                                    $thumbnailExists = file_exists(public_path('/storage/curriculums/thumbnails/' . pathinfo($user->curriculum, PATHINFO_FILENAME) . '.jpg'));
                                @endphp

                                <div class="{{ $thumbnailExists ? 'image-wrapper' : 'placeholder-wrapper' }} h-100 w-100">
                                    @if($thumbnailExists)
                                        <img src="{{ $imagePath }}"
                                             alt="Currículo de {{ $user->name }}"
                                             class="curriculum-image {{ $thumbnailExists ? 'loaded' : '' }}"
                                             loading="lazy"
                                             onerror="this.onerror=null;this.classList.remove('loaded');">
                                    @endif

                                    <div class="curriculum-placeholder card-img-top {{ !$thumbnailExists ? 'active' : '' }}">
                                        <div class="placeholder-content text-center p-3 ">
                                            <i class="bi bi-file-earmark-pdf display-4 text-primary opacity-75"></i>
                                            <h6 class="mt-2 mb-0 text-muted">Currículo PDF</h6>
                                            <small class="text-muted">{{ $user->name }}</small>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary mb-2">{{ $user->name }}</h5>

                                <p class="card-text mb-2"><strong>Email:</strong> {{ $user->email }}</p>

                                <p class="card-text mb-2">
                                    <strong>Sexo:</strong> {{ ucfirst($user->sexo) ?? 'Não informado' }}
                                </p>

                                <p class="card-text mb-2">
                                    <strong>Tipo de
                                        deficiência:</strong> {{ ucfirst($user->disability_type) ?? 'Não informado' }}
                                </p>

                                <p class="card-text mb-2">
                                    <strong>Área de interesse:</strong>
                                <div class="mb-3">
                                            <span class="badge bg-primary-subtle text-primary-emphasis">
                                                {{ $user->interest_area ?? 'Área não informada' }}
                                            </span>
                                </div>
                                </p>

                                <p class="card-text mb-3">
                                    <strong>LinkedIn:</strong>
                                    @if($user->linkedin)
                                        <a class="link-offset-2 link-underline link-underline-opacity-0" href="{{ $user->linkedin }}" target="_blank"
                                           rel="noopener noreferrer">Link para o linkedin</a>
                                    @else
                                        Não informado
                                    @endif
                                </p>

                                <p class="card-text mb-1">
                                    <strong>Disponibilidade de
                                        trabalho:</strong>
                                <div class="mb-3">
                                            <span class="badge bg-primary-subtle text-primary-emphasis">
                                    {{ ucfirst($user->work_availability) ?? 'Não informado' }}
                                            </span>
                                </div>

                                </p>

                                <div class="mt-3 text-end">
                                    <a href="{{ route('curriculum.download', ['id' => $user->id]) }}"
                                       class="btn btn-outline-success btn-sm">
                                        Baixar Currículo
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.querySelector('form[method="GET"]');
                const selects = filterForm.querySelectorAll('select');

                selects.forEach(select => {
                    select.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });
            });
        </script>
    @endpush
@endsection
