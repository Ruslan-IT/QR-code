<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LinkPdfController extends Controller
{
    public function show(Link $link): BinaryFileResponse
    {
        // Проверяем, есть ли PDF файл у ссылки
        if (!$link->pdf_file) {
            abort(404, 'PDF file not found');
        }

        $path = storage_path('app/public/' . $link->pdf_file);

        if (!file_exists($path)) {
            abort(404, 'PDF file not found on server');
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $link->title . '.pdf"'
        ]);
    }
}
