<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Table;
use App\Models\People;
use App\Models\User;
use Filament\Notifications\Notification;


class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
                    ->columns([
                        TextColumn::make('name')
                            ->label('Nama Lengkap')
                            ->searchable()
                            ->sortable(),

                        TextColumn::make('username')
                            ->label('Username')
                            ->searchable()
                            ->copyable()
                            ->copyMessage('Username disalin!'),

                        TextColumn::make('email')
                            ->label('Email')
                            ->searchable(),

                        IconColumn::make('is_admin')
                            ->label('Admin Sistem')
                            ->boolean()
                            ->sortable(),
                        TextColumn::make('person.role')
                            ->label('Peran (Sekolah)')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'teacher' => 'success',
                                'staff' => 'warning',
                                'student' => 'info',
                                default => 'gray',
                            })
                            ->default('Tidak Ada')
                            ->sortable(),

                        TextColumn::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                            ])
                            ->headerActions([
                                            Action::make('generate_massal')
                                                ->label('Generate Akun Massal')
                                                ->icon('heroicon-o-sparkles') // Ikon bintang/ajaib
                                                ->color('primary')
                                                ->requiresConfirmation()
                                                ->modalHeading('Generate Akun Otomatis')
                                                ->modalDescription('Sistem akan mencari data di tabel People yang belum terhubung dengan akun login, lalu membuatkan akun secara otomatis.')
                                                ->form([
                                                    TextInput::make('default_password')
                                                        ->label('Password Seragam')
                                                        ->password()
                                                        ->revealable()
                                                        ->required()
                                                        ->default('sekolah123') // Default password
                                                        ->helperText('Password ini akan digunakan untuk semua akun yang baru dibuat.'),
                                                ])
                                                ->action(function (array $data) {
                                                    set_time_limit(0);
                                                    $peopleWithoutAccount = People::whereNull('user_id')->get();
                                                    $count = 0;

                                                    foreach ($peopleWithoutAccount as $person) {
                                                        // 2. Bikin username bebas (Misal: nama huruf kecil disambung + ID person agar unik)
                                                        // Hapus spasi dan karakter non-alfabet
                                                        $cleanName = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $person->name));
                                                        $username = $cleanName . $person->id;

                                                        // 3. Ambil email (kalau kosong, bikin email dummy dari username)
                                                        $email = $person->email ?? $username . '@sekolah.local';

                                                        // 4. Pastikan tidak ada duplikat email atau username di database untuk mencegah error
                                                        if (User::where('email', $email)->orWhere('username', $username)->exists()) {
                                                            continue; // Lewati jika sudah ada yang pakai
                                                        }

                                                        // 5. Buat User baru
                                                        $user = User::create([
                                                            'name'     => $person->name,
                                                            'email'    => $email,
                                                            'username' => $username,
                                                            'password' => $data['default_password'], // Sudah otomatis ter-hash di model
                                                            'is_admin' => false,
                                                        ]);

                                                        // 6. Sambungkan user_id ke tabel People
                                                        $person->update(['user_id' => $user->id]);

                                                        $count++;
                                                    }

                                                    // 7. Tampilkan Notifikasi Sukses
                                                    Notification::make()
                                                        ->title('Proses Selesai!')
                                                        ->body("Berhasil membuat {$count} akun baru.")
                                                        ->success()
                                                        ->send();
                                                }),
                                        ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
