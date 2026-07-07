<?php

namespace App\Filament\Resources\StudentReports\Pages;

use App\Filament\Resources\StudentReports\StudentReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\Classroom;
use App\Models\StudentReport; // WAJIB DITAMBAHKAN: Import model StudentReport
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStudentReports extends ListRecords
{
    protected static string $resource = StudentReportResource::class;

    // --- FITUR AUTO-REDIRECT UNTUK SISWA ---
    public function mount(): void
    {
        parent::mount();

        $user = auth()->user();

        // Jika yang login adalah siswa, langsung lempar ke halaman View laporannya
        if ($user?->people?->role === 'student') {
            // Sesuaikan 'student_id' jika di database Anda namanya 'people_id'
            $report = StudentReport::where('student_id', $user->people->id)->first();

            if ($report) {
                // Redirect langsung ke URL view, tabel tidak akan sempat dirender
                $this->redirect(StudentReportResource::getUrl('view', ['record' => $report->id]));
            }
        }
    }

    // 1. Menyesuaikan Judul Halaman
    public function getTitle(): string
    {
        $user = auth()->user();

        if ($user?->is_admin == 1 || (bool) $user?->is_admin) {
            return 'Laporan Siswa Seluruh Kelas';
        }

        if ($user?->people?->role === 'student') {
            return 'Laporan Pembelajaran Saya';
        }

        $classroomName = $user?->people?->classroom?->name;

        if ($classroomName) {
            return "Laporan Siswa Kelas {$classroomName}";
        }

        return 'Laporan Siswa';
    }

    // 2. Menyesuaikan Deskripsi Halaman
    public function getSubheading(): ?string
    {
        $user = auth()->user();

        if ($user?->is_admin == 1 || (bool) $user?->is_admin) {
            return 'Pantau dan kelola laporan siswa dari seluruh kelas di sini.';
        }

        if ($user?->people?->role === 'student') {
            return 'Berikut adalah detail laporan pembelajaran Anda.';
        }

        return 'Berikut adalah rekapitulasi laporan siswa untuk kelas Anda.';
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    // 3. Menyesuaikan Tab Kelas Berdasarkan Hak Akses
    public function getTabs(): array
    {
        $user = auth()->user();
        $tabs = [];

        // --- SEMBUNYIKAN TAB UNTUK SISWA ---
        if ($user?->people?->role === 'student') {
            return []; // Kembalikan array kosong agar tab "1A" hilang
        }

        // Cek apakah user adalah admin
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
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('student.classroom', function ($query) use ($classroom) {
                    $query->where('id', $classroom->id);
                }));
        }

        return $tabs;
    }
}
