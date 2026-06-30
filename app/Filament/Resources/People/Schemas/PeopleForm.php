<?php
namespace App\Filament\Resources\People\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PeopleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap') // Ubah label
                    ->required(),
                TextInput::make('email')
                    ->label('Alamat Email') // Ubah label
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Nomor Telepon') // Ubah label
                    ->tel(),
                TextInput::make('id_number')
                    ->label('Nomor Identitas') // Ubah label
                    ->required(),
                Select::make('role')
                    ->label('Peran') // Ubah label
                    ->options([
                        'teacher' => 'Guru',
                        'student' => 'Murid',
                        'staff'   => 'Staf'
                    ])
                    ->required(),
                Select::make('classroom_id')
                    ->label('Kelas') // Ubah label
                    ->relationship('classroom', 'name')
                    ->placeholder('Pilih Kelas') // Tambahkan placeholder
                    ->searchable() // Tambahkan agar mudah dicari
                    ->preload(),
            ]);
    }
}
