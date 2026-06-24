<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AchievementPeople extends Pivot
{
    protected $table = 'achievement_people';


    protected $fillable = ['achievement_id', 'people_id'];


}
