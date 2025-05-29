<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Spatie\PdfToImage\Pdf;

class PostsController extends \Illuminate\Routing\Controller
{
    public function index(): Factory|\Illuminate\View\View
    {
        $curriculums = Storage::files('public/curriculums');
        return view('post', compact('curriculums'));
    }

    public function uploadCurriculum(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'curriculum' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        try {
            if ($user->curriculum) {
                $oldFilePath = 'public/curriculums/' . $user->curriculum;
                if (Storage::exists($oldFilePath)) {
                    Storage::delete($oldFilePath);
                }

                $oldThumbPath = 'public/curriculums/thumbnails/' . pathinfo($user->curriculum, PATHINFO_FILENAME) . '.jpg';
                if (Storage::exists($oldThumbPath)) {
                    Storage::delete($oldThumbPath);
                }
            }

            $file = $request->file('curriculum');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/curriculums', $filename);

            if ($file->getClientOriginalExtension() === 'pdf') {
                $pdfPath = storage_path('app/public/curriculums/' . $filename);

                $thumbnailPath = storage_path('app/public/curriculums/thumbnails/');
                if (!file_exists($thumbnailPath)) {
                    mkdir($thumbnailPath, 0755, true);
                }

                $thumbnailName = pathinfo($filename, PATHINFO_FILENAME) . '.jpg';

                $pdf = new Pdf($pdfPath);
                $pdf->setPage(1)->saveImage($thumbnailPath . DIRECTORY_SEPARATOR . $thumbnailName);
            }

            $user->update([
                'curriculum' => $filename,
            ]);

            return back()->with('success', 'Currículo enviado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar currículo: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->with('error', 'Erro ao enviar o currículo. Tente novamente.');
        }
    }

    public function downloadCurriculum(): RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $user = Auth::user();

        if (!$user->curriculum) {
            return back()->with('error', 'Nenhum currículo encontrado.');
        }

        $filePath = storage_path('app/public/curriculums/' . $user->curriculum);

        if (!File::exists($filePath)) {
            return back()->with('error', 'Arquivo não encontrado.');
        }

        return Response::download($filePath);
    }

    /**
     * Faz o download do currículo de um usuário específico.
     */
    public function downloadUserCurriculum($id): RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $user = User::find($id);

        if (!$user || !$user->curriculum) {
            return back()->with('error', 'Currículo não encontrado.');
        }

        $filePath = storage_path('app/public/curriculums/' . $user->curriculum);

        if (!File::exists($filePath)) {
            return back()->with('error', 'Arquivo não encontrado.');
        }

        return Response::download($filePath);
    }
}
