<?php

namespace App\Filament\Resources\Attendances\Pages;

use App\Filament\Resources\Attendances\AttendanceResource;
use App\Models\Classroom;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    // 1. Mengubah Judul Halaman (Title)
    public function getTitle(): string
    {
        $user = auth()->user();

        if ($user?->is_admin === true) {
            return 'Catatan Kehadiran Seluruh Kelas';
        }

        // Ambil nama kelas jika user bukan admin
        $classroomName = $user?->people?->classroom?->name;

        if ($classroomName) {
            return "Catatan Kehadiran Kelas {$classroomName}";
        }

        return 'Catatan Kehadiran'; // Fallback jika kelas tidak ditemukan
    }

    // 2. Menambahkan Deskripsi Singkat (Subheading)
    public function getSubheading(): ?string
    {
        $user = auth()->user();

        if ($user?->is_admin === true) {
            return 'Pantau dan kelola data kehadiran siswa dari seluruh kelas di sini.';
        }

        return 'Berikut adalah rekapitulasi data kehadiran untuk kelas Anda.';
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

        if ($user?->is_admin === true) {
            $classrooms = Classroom::all();
        }
        else {
            $classroomId = $user?->people?->classroom_id ?? $user?->people?->classroom?->id;
            $classrooms = $classroomId ? Classroom::where('id', $classroomId)->get() : collect();
        }

        foreach ($classrooms as $classroom) {
            $tabs[$classroom->name] = Tab::make($classroom->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('student.classroom', function ($query) use ($classroom) {
                    $query->where('id', $classroom->id);
                }));
        }

        return $tabs;
    }
}
