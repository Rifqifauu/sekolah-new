<?php

namespace App\Filament\Resources\StudentReports\Pages;

use App\Filament\Resources\StudentReports\StudentReportResource;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentReport extends ViewRecord
{
    protected static string $resource = StudentReportResource::class;

    protected string $view = 'filament.resources.student-reports.pages.view-report';

    protected function getViewData(): array
    {
        // 1. Ambil semua nilai siswa dan hitung nilai aslinya
        $grades = \App\Models\Grade::with('gradeComponent.subject')
            ->where('student_id', $this->record->student_id)
            ->where('academic_period_id', $this->record->academic_period_id)
            ->get()
            ->map(function ($grade) {
                // Ambil weight (bobot) dari tabel grade_components.
                // Default ke 100 jika tidak ada untuk menghindari error pembagian dengan 0 (Division by zero).
                $weight = $grade->gradeComponent->weight ?? 100;

                // Rumus: Nilai Asli = Nilai Tersimpan / (Bobot / 100)
                // Atau disederhanakan: (Nilai Tersimpan * 100) / Bobot
                if ($weight > 0) {
                    $originalScore = ($grade->score * 100) / $weight;
                    // Kita bulatkan agar tidak ada nilai desimal yang terlalu panjang (opsional)
                    $grade->original_score = round($originalScore, 2);
                } else {
                    $grade->original_score = $grade->score;
                }

                return $grade;
            });

        $subjectsData = $grades->groupBy(fn ($grade) => $grade->gradeComponent->subject->name ?? 'Tanpa Nama Subjek');

        // 2. Hitung Ranking
        $allReportsInClass = \App\Models\StudentReport::where('academic_period_id', $this->record->academic_period_id)
            ->where('teacher_id', $this->record->teacher_id)
            ->get()
            ->sortByDesc(fn ($report) => $report->average_score)
            ->values();

        $rankPosition = $allReportsInClass->pluck('id')->search($this->record->id) !== false
            ? $allReportsInClass->pluck('id')->search($this->record->id) + 1
            : '-';

        return [
            'report' => $this->record,
            'subjectsData' => $subjectsData,
            'attendance' => $this->record->attendance_summary,
            'rank' => $rankPosition,
            'totalStudents' => $allReportsInClass->count(),
        ];
    }
}
