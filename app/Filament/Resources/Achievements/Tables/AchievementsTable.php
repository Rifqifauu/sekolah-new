<?php

namespace App\Filament\Resources\Achievements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class AchievementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Prestasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->badge(), // Menambahkan badge agar lebih visual
                TextColumn::make('level')
                    ->label('Tingkat')
                    ->searchable(),
                TextColumn::make('rank')
                    ->label('Peringkat')
                    ->searchable(),
                TextColumn::make('year')
                    ->label('Tahun'),
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square(), // Mengatur tampilan gambar menjadi kotak
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Contoh filter kategori (sesuaikan opsi dengan data Anda)
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'akademik' => 'Akademik',
                        'non-akademik' => 'Non-Akademik',
                        'olahraga' => 'Olahraga',
                    ])
                    ->placeholder('Semua Kategori'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
