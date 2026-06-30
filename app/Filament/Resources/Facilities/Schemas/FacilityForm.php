<?php

namespace App\Filament\Resources\Facilities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Fasilitas')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull()
                    ->rows(3),

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'akademik' => 'Akademik',
                        'olahraga' => 'Olahraga',
                        'seni'     => 'Seni',
                        'umum'     => 'Umum',
                    ])
                    ->required()
                    ->placeholder('Pilih Kategori'),

                FileUpload::make('image')
                    ->label('Gambar Fasilitas')
                    ->image()
                    ->disk('public')
                    ->directory('facilities') // Menyimpan gambar di folder khusus 'facilities'
                    ->required(),
            ]);
    }
}
