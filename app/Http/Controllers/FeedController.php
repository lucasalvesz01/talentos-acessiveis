<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Corrigido o import do Request
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use App\Models\User;

class FeedController extends Controller // Removida a barra invertida desnecessária
{
    public function index(Request $request): Factory|View
    {
        $query = User::whereNotNull('curriculum'); // Inicia a query filtrando apenas usuários com currículo

        // Filtro por área de interesse
        if ($request->has('interest_area') && $request->interest_area != 'all') {
            $query->where('interest_area', $request->interest_area);
        }

        // Filtro por tipo de deficiência
        if ($request->has('disability_type') && $request->disability_type != 'all') {
            $query->where('disability_type', $request->disability_type);
        }

        // Filtro por disponibilidade
        if ($request->has('work_availability') && $request->work_availability != 'all') {
            $query->where('work_availability', $request->work_availability);
        }

        $users = $query->paginate(10); // Obtém os resultados paginados

        // Obter valores únicos para os filtros
        $interestAreas = User::whereNotNull('curriculum')
            ->select('interest_area')
            ->distinct()
            ->whereNotNull('interest_area')
            ->pluck('interest_area');

        $disabilityTypes = User::whereNotNull('curriculum')
            ->select('disability_type')
            ->distinct()
            ->whereNotNull('disability_type')
            ->pluck('disability_type');

        $availabilities = User::whereNotNull('curriculum')
            ->select('work_availability')
            ->distinct()
            ->whereNotNull('work_availability')
            ->pluck('work_availability');

        return view('feed', compact('users', 'interestAreas', 'disabilityTypes', 'availabilities')); // Corrigido para 'feed' (seu nome de view)
    }
}
