<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Grade;
use App\Models\Attendance; // Pastikan untuk meng-import model Attendance

class StudentReport extends Model
{
    protected $fillable = ['student_id', 'teacher_id', 'academic_period_id', 'notes', 'status'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(People::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(People::class, 'teacher_id');
    }

    public function academicPeriod(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function grades()
    {
        return Grade::where('student_id', $this->student_id)
                    ->where('academic_period_id', $this->academic_period_id);
    }

    public function getAverageScoreAttribute()
    {
        $grades = Grade::with('gradeComponent')
            ->where('student_id', $this->student_id)
            ->where('academic_period_id', $this->academic_period_id)
            ->get();

        if ($grades->isEmpty()) {
            return 0;
        }

        $subjectScores = $grades->groupBy(function ($grade) {
            return $grade->gradeComponent->subject_id;
        })->map(function ($subjectGrades) {
            return $subjectGrades->sum(function ($grade) {
                return $grade->score;
            });
        });

        $availableSubjectCount = $subjectScores->count();

        if ($availableSubjectCount === 0) {
            return 0;
        }

        return $subjectScores->sum() / $availableSubjectCount;
    }

    // --- FUNGSI BARU UNTUK MENGHITUNG KEHADIRAN ---

    public function getAttendanceSummaryAttribute()
    {
        // 1. Definisikan nilai default agar tidak error jika data kosong
        $defaultCounts = [
            'present'    => 0,
            'absent'     => 0,
            'late'       => 0,
            'permission' => 0,
            'sick'       => 0,
        ];

        $attendanceData = Attendance::where('student_id', $this->student_id)
            ->where('academic_period_id', $this->academic_period_id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return array_merge($defaultCounts, $attendanceData);
    }
}
