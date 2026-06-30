<?php

namespace App\Filament\Resources\People\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;


class PeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
                ->label('Nama') // Menyesuaikan label
                ->searchable(),
            TextColumn::make('email')
                ->label('Alamat Email') // Menyesuaikan label
                ->searchable(),
            TextColumn::make('phone')
                ->label('No. Telepon') // Menyesuaikan label
                ->searchable(),
            TextColumn::make('id_number')
                ->label('Nomor Identitas') // Menyesuaikan label
                ->searchable(),
            TextColumn::make('role')
                ->label('Peran') // Menyesuaikan label
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'teacher' => 'info',
                    'student' => 'success',
                    'staff'   => 'warning',
                    default   => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'teacher' => 'Guru',
                    'student' => 'Murid',
                    'staff'   => 'Staf',
                    default   => $state,
                }),
            TextColumn::make('classroom.name')
                ->label('Kelas')
                ->searchable(),
            TextColumn::make('created_at')
                ->label('Dibuat pada') // Menyesuaikan label
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label('Diperbarui pada') // Menyesuaikan label
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'teacher' => 'Guru',
                        'student' => 'Murid',
                        'staff'   => 'Staff',
                    ])
                    ->label('Role')
                    ->placeholder('Pilih Role')
                    ->default('student'), // Mengatur 'student' sebagai pilihan awal

                SelectFilter::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->label('Kelas')
                    ->placeholder('Pilih Kelas')
                    ->searchable()
                    ->preload()
                    ->default(1), // Mengatur ID kelas (misal: 1) sebagai pilihan awal
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
