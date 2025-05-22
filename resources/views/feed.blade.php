@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h3 class="fw-bold text-primary">Feed de Currículos</h3>
        </div>

        @if ($users->isEmpty())
            <div class="text-center text-muted">
                <p>Nenhum currículo foi enviado ainda.</p>
            </div>
        @else
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-md-4 mb-4 d-flex w-50">
                        <div class="card w-100 shadow border-0 rounded-4">
                            @php
                                $imageName = pathinfo($user->curriculum, PATHINFO_FILENAME) . '.jpg';
                                $imagePath = asset('storage/curriculums/thumbnails/' . $imageName);
                            @endphp

                            <div class="d-flex justify-content-center align-items-center bg-light" style="height: 200px;">
                                <img src="{{ $imagePath }}" alt="Currículo de {{ $user->name }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary mb-2">{{ $user->name }}</h5>
                                <p class="card-text mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                                <p class="card-text mb-1">
                                    <strong>Tipo de deficiência:</strong> {{ $user->disability_type ?? 'Não informado' }}
                                </p>                                <div class="mt-3 text-end">
                                    <a href="{{ route('curriculum.download', ['id' => $user->id]) }}" class="btn btn-outline-success btn-sm">
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
@endsection
