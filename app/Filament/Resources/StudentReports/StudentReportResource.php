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
use Illuminate\Database\Eloquent\Builder; // Jangan lupa import ini untuk Builder query

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

    // 1. Perbarui hak akses untuk mengizinkan siswa
    public static function canAccess(): bool
    {
        $user = auth()->user();

        // Cek apakah admin, ATAU rolenya guru/siswa
        return ($user?->is_admin === true) || in_array($user?->people?->role, ['teacher', 'student']);
    }

    // 2. Tambahkan filter query untuk membatasi data yang dilihat siswa
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        // Admin dan Guru bisa melihat semua data
        if ($user?->is_admin === true || $user?->people?->role === 'teacher') {
            return $query;
        }

        // Siswa hanya bisa melihat datanya sendiri
        if ($user?->people?->role === 'student') {
            // Ganti 'student_id' menjadi 'people_id' jika nama kolom di database Anda menggunakan people_id
            return $query->where('student_id', $user->people->id);
        }

        // Jika tidak masuk kondisi apa pun, kosongkan data
        return $query->whereNull('id');
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
