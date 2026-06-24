<?php

namespace App\Filament\Resources\AcademicPeriods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AcademicPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->required(),
                Select::make('semester')
                    ->options(['odd' => 'Odd', 'even' => 'Even'])
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
