<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('academic_period_id')
                    ->relationship('academicPeriod', 'id')
                    ->required(),
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required(),
                Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                Select::make('status')
                    ->options([
            'present' => 'Present',
            'absent' => 'Absent',
            'late' => 'Late',
            'permission' => 'Permission',
            'sick' => 'Sick',
        ])
                    ->required(),
                TextInput::make('note'),
            ]);
    }
}
