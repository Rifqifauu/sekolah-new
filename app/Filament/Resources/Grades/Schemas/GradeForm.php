<?php

namespace App\Filament\Resources\Grades\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required(),
                Select::make('grade_component_id')
                    ->relationship('gradeComponent', 'name')
                    ->required(),
                TextInput::make('score')
                    ->required()
                    ->numeric(),
                Textarea::make('feedback')
                    ->columnSpanFull(),
                Select::make('academic_period_id')
                    ->relationship('academicPeriod', 'id')
                    ->required(),
            ]);
    }
}
