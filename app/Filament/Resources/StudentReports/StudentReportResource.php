<?php

namespace App\Filament\Resources\StudentReports;

use App\Filament\Resources\StudentReports\Pages\CreateStudentReport;
use App\Filament\Resources\StudentReports\Pages\ViewStudentReport;
use App\Filament\Resources\StudentReports\Pages\ListStudentReports;
use App\Filament\Resources\StudentReports\Schemas\StudentReportForm;
use App\Filament\Resources\StudentReports\Tables\StudentReportsTable;
use App\Models\StudentReport;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentReportResource extends Resource
{
    protected static ?string $model = StudentReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?string $modelLabel = 'Laporan Pembelajaran';
    protected static string | UnitEnum | null $navigationGroup = 'Penilaian';
    public static function form(Schema $schema): Schema
    {
        return StudentReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentReports::route('/'),
            'create' => CreateStudentReport::route('/create'),
            'view' => ViewStudentReport::route('/{record}/view'),
        ];
    }
}
