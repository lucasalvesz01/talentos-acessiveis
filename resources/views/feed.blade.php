@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0 rounded-4 mt-5">
                    <div class="card-header bg-transparent border-bottom text-center">
                        <h3 class="fw-bold text-primary">Feeds de Currículos</h3>
                    </div>

                    <div class="card-body">
                        @if ($users->isEmpty())
                            <p class="text-center">Nenhum currículo foi enviado ainda.</p>
                        @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Data do Envio</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('curriculum.download') }}?id={{ $user->id }}" class="btn btn-success btn-sm">
                                                    Baixar Currículo
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection