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
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('id_number')
                    ->required(),
                Select::make('role')
                    ->options(['teacher' => 'Teacher', 'student' => 'Student', 'staff' => 'Staff'])
                    ->required(),
                Select::make('classroom_id')
                    ->relationship('classroom', 'name'),
            ]);
    }
}
