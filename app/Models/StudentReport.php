<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
