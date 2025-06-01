<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UploadCurriculumRequest;
use App\Models\User;
use Illuminate\View\View;
use Spatie\PdfToImage\Pdf;

class PostsController extends \Illuminate\Routing\Controller
{
    public function index(): Factory|View
    {
        $curriculums = Storage::files('public/curriculums');
        return view('post', compact('curriculums'));
    }

    public function uploadCurriculum(UploadCurriculumRequest $request): RedirectResponse
    {
        $user = Auth::user();

        try {
            // Remove arquivos antigos, se existirem
            if ($user->curriculum) {
                Storage::delete('public/curriculums/' . $user->curriculum);
                Storage::delete('public/curriculums/thumbnails/' . pathinfo($user->curriculum, PATHINFO_FILENAME) . '.jpg');
            }

            $file = $request->file('curriculum');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Salva arquivo PDF
            $file->storeAs('public/curriculums', $filename);

            // Cria thumbnail da primeira página do PDF
            if ($file->getClientOriginalExtension() === 'pdf') {
                $pdfPath = storage_path('app/public/curriculums/' . $filename);
                $thumbnailDir = storage_path('app/public/curriculums/thumbnails');

                if (!File::exists($thumbnailDir)) {
                    Storage::makeDirectory('public/curriculums/thumbnails');
                }

                $thumbnailName = pathinfo($filename, PATHINFO_FILENAME) . '.jpg';

                $pdf = new Pdf($pdfPath);
                $pdf->setPage(1)->saveImage($thumbnailDir . DIRECTORY_SEPARATOR . $thumbnailName);
            }

            // Atualiza o nome do arquivo no usuário
            $user->update(['curriculum' => $filename]);

            return redirect()->route('feeds.index')->with('success', 'Currículo enviado com sucesso!');
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
