<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class People extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'id_number', 'role', 'classroom_id'];
    protected $table = 'people';

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    // Relasi jika Person ini adalah siswa
    public function attendancesAsStudent(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function reportsAsStudent(): HasMany
    {
        return $this->hasMany(StudentReport::class, 'student_id');
    }

    // Relasi jika Person ini adalah guru
    public function attendancesGiven(): HasMany
    {
        return $this->hasMany(Attendance::class, 'teacher_id');
    }

    public function reportsGiven(): HasMany
    {
        return $this->hasMany(StudentReport::class, 'teacher_id');
    }
    public function achievements() {
        return $this->belongsToMany(Achievement::class, 'achievement_people', 'people_id', 'achievement_id');
    }
}
