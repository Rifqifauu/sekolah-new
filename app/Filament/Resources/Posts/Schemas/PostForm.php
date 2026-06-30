<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor; // Import RichEditor
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->live(onBlur: true) // Mendengarkan perubahan saat kursor keluar dari field
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                                ->label('Slug')
                                ->required()

                                ->hidden()
                                ->unique(ignoreRecord: true),
                RichEditor::make('content')
                    ->label('Isi Konten')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([ // Mengatur tombol editor yang muncul
                        'bold', 'italic', 'underline', 'strike',
                        'bulletList', 'orderedList', 'link', 'blockquote',
                        'h2', 'h3', 'undo', 'redo',
                    ]),

                FileUpload::make('image')
                    ->label('Gambar Utama')
                    ->image()
                    ->disk('public')
                    ->directory('posts'),

                Select::make('type')
                    ->label('Tipe Konten')
                    ->options([
                        'article'       => 'Artikel',
                        'news'          => 'Berita',
                        'announcement'  => 'Pengumuman',
                    ])
                    ->default('article')
                    ->required(),

                Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(true),

                Select::make('user_id')
                    ->label('Penulis')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
