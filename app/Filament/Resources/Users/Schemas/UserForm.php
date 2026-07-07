<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Masukkan detail login dan kredensial pengguna.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('username')
                                    ->label('Username')
                                    ->required()
                                    ->unique(ignoreRecord: true) // Mencegah bentrok dengan user lain, tapi aman saat edit
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->revealable() // Menampilkan icon mata untuk melihat password
                                    // Wajib diisi saat membuat user baru ('create'), tapi opsional saat edit ('edit')
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    // Hanya mengirim data password ke database jika field ini tidak kosong
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->maxLength(255),
                            ]),

                        Toggle::make('is_admin')
                            ->label('Jadikan Admin Sistem')
                            ->helperText('Berikan akses penuh ke pengguna ini untuk mengelola aplikasi.')
                            ->default(false)
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
