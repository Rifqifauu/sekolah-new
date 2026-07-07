<?php

namespace App\Filament\Resources\Grades\Pages;

use App\Filament\Resources\Grades\GradeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use App\Models\Classroom;

class ListGrades extends ListRecords
{
    protected static string $resource = GradeResource::class;

    // 1. Menyesuaikan Judul Halaman
    public function getTitle(): string
    {
        $user = auth()->user();

        if ($user?->is_admin == 1 || (bool) $user?->is_admin) {
            return 'Daftar Nilai Seluruh Kelas';
        }

        $classroomName = $user?->people?->classroom?->name;

        if ($classroomName) {
            return "Daftar Nilai Kelas {$classroomName}";
        }

        return 'Daftar Nilai';
    }

    public function getSubheading(): ?string
    {
        $user = auth()->user();

        if ($user?->is_admin == 1 || (bool) $user?->is_admin) {
            return 'Pantau dan kelola data nilai siswa dari seluruh kelas di sini.';
        }

        return 'Berikut adalah rekapitulasi data nilai untuk kelas Anda.';
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $user = auth()->user();
        $tabs = [];

        if ($user?->is_admin == 1 || (bool) $user?->is_admin) {
            $classrooms = Classroom::all();
        }
        else {
            $classroomId = $user?->people?->classroom_id ?? $user?->people?->classroom?->id;

            if ($classroomId) {
                $classrooms = Classroom::where('id', $classroomId)->get();
            } else {
                return [
                    'Error' => Tab::make('Belum Ada Kelas')
                        ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('id'))
                ];
            }
        }

        foreach ($classrooms as $classroom) {
            $tabs[$classroom->name] = Tab::make($classroom->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('classroom', function ($query) use ($classroom) {
                    $query->where('id', $classroom->id);
                }));
        }

        return $tabs;
    }
}
