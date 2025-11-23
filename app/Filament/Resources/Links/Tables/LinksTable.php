<?php

namespace App\Filament\Resources\Links\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('pdf_file')
                    ->label('PDF File')
                    ->formatStateUsing(fn ($state) => $state ? '✓ Загружен' : '—')
                    ->color(fn ($state) => $state ? 'success' : 'gray'),

                ImageColumn::make('qr_code')
                    ->label('QR Code')
                    ->disk('public')
                    ->url(fn ($record) => route('links.pdf.view', $record))
                    ->width(50)
                    ->height(50)
                    ->default('QR-код будет сгенерирован после сохранения'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('view_pdf')
                    ->label('View PDF')
                    ->url(fn ($record) => route('links.pdf.view', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => !empty($record->pdf_file))
                    ->color('success'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
