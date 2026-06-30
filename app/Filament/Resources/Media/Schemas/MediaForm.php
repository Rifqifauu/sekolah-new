<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('path')
                ->label("Gambar/Video")
                    ->required()
                    ->disk("public"),
                Select::make('type')
                    ->options(['image' => 'Image', 'video' => 'Video'])
                    ->required(),
                TextInput::make('name')
                ->label('nama')
                    ->required(),
                TextInput::make('description')
                ->label('deskripsi')
                    ->required(),
            ]);
    }
}
