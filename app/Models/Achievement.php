<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    // Tambahkan kolom yang sesuai dengan tabel Anda
    protected $fillable = ['title', 'category', 'level', 'rank', 'year', 'image'];

    public function students() {
        return $this->belongsToMany(People::class, 'achievement_people', 'achievement_id', 'people_id');
    }
}
