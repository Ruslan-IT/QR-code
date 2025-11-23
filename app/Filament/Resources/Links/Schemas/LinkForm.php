<?php

namespace App\Filament\Resources\Links\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Название для вашего PDF файла'),

                FileUpload::make('pdf_file')
                    ->label('PDF File')
                    ->directory('pdfs')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240) // 10MB
                    ->required()
                    ->helperText('Загрузите PDF файл (макс. 10MB)'),

                FileUpload::make('qr_code')
                    ->label('QR Code')
                    ->directory('qr_codes')
                    ->image()
                    ->visibleOn('edit')
                    ->disabled()
                    ->helperText('QR-код генерируется автоматически после сохранения'),
            ]);
    }
}
