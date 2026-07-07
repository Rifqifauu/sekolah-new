<?php

namespace App\Filament\Resources\DataGurus\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section; // Tambahkan ini jika ingin mencoba mengelompokkan form

class DataGuruForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Foto Profil')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('guru')
                    ->avatar(),

                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),

                TextInput::make('id_number')
                    ->label('Nomor Identitas (NIP)')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ])
                    ->required(),

                TextInput::make('position')
                    ->label('Jabatan/Posisi')
                    ->placeholder('Contoh: Wali Kelas / Guru Matematika'),

                // -- Kontak & Relasi --
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required(),

                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel(),

                Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->placeholder('Pilih Kelas')
                    ->searchable()
                    ->preload(),

                TextInput::make('role')
                    ->label('Peran')
                    ->default('teacher')
                    ->hidden(),
            ]);
    }
}
