<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Link extends Model
{
    protected $fillable = ['title', 'pdf_file', 'qr_code'];

    protected static function booted()
    {
        static::created(function ($link) {
            // Генерируем URL для просмотра PDF
            $pdfUrl = route('links.pdf.view', ['link' => $link->id]);

            // Генерируем QR-код который ведет на PDF
            $qrCode = QrCode::format('png')
                ->size(300)
                ->generate($pdfUrl);

            // Сохраняем QR-код
            $filename = 'qr_codes/' . uniqid() . '.png';
            Storage::disk('public')->put($filename, $qrCode);

            // Обновляем модель, сохраняя путь к QR-коду
            $link->update(['qr_code' => $filename]);
        });

        // Удаление файлов при удалении записи
        static::deleting(function ($link) {
            if ($link->qr_code) {
                Storage::disk('public')->delete($link->qr_code);
            }
            if ($link->pdf_file) {
                Storage::disk('public')->delete($link->pdf_file);
            }
        });
    }

    // Accessor для получения полного URL к PDF
    public function getPdfUrlAttribute()
    {
        return $this->pdf_file ? Storage::disk('public')->url($this->pdf_file) : null;
    }
}
