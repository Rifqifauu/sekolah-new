<?php

namespace App\Filament\Resources\DataGurus\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class DataGurusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->size(40),

                TextColumn::make('name')
                    ->label('Guru')
                    ->description(fn ($record) => $record->email) // Email tampil di bawah nama
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('id_number')
                    ->label('NIP/Identitas')
                    ->description(fn ($record) => $record->position)
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Kontak')
                    ->icon('heroicon-m-phone')
                    ->searchable(),

                TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->badge() // Membuat label kelas terlihat seperti tag
                    ->color('info')
                    ->searchable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
