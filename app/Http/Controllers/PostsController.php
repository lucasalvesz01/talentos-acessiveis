<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index(): Factory|View|Application
    {
        $curriculums = Storage::files('curriculums');

        return view('post', compact('curriculums'));
    }

    public function uploadCurriculum(Request $request)
    {
        // Validação do arquivo enviado
        $request->validate([
            'curriculum' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = Auth::user();
        if ($user->curriculum) {
            Storage::delete($user->curriculum);
        }

        $path = $request->file('curriculum')->store('curriculums');

        $user->curriculum = $path;
        $user->save();

        return back()->with('success', 'Currículo enviado com sucesso!');
    }
}
