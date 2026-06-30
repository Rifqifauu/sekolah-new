<?php

namespace App\Filament\Resources\Achievements\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AchievementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Prestasi')
                    ->required()
                    ->maxLength(255),

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'akademik'     => 'Akademik',
                        'non-akademik' => 'Non-Akademik',
                        'olahraga'     => 'Olahraga',
                    ])
                    ->required(),

                TextInput::make('level')
                    ->label('Tingkat')
                    ->placeholder('Contoh: Nasional, Internasional')
                    ->required(),

                TextInput::make('rank')
                    ->label('Peringkat / Juara')
                    ->placeholder('Contoh: Juara 1')
                    ->required(),

                TextInput::make('year')
                    ->label('Tahun')
                    ->numeric() // Memastikan hanya angka yang bisa diinput
                    ->maxValue(date('Y') + 1) // Validasi tahun tidak lebih dari tahun depan
                    ->required(),

                FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->disk('public')
                    ->preserveFilenames(),
            ]);
    }
}
