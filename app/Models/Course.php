<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\CourseController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getLinksAttribute()
    {
        return [
            'index' => action(
                [CourseController::class, 'index']
            ),
            'show' => action(
                [CourseController::class, 'show'],
                $this->id
            ),
        ];
    }

    public function cohorts()
    {
        return $this->hasMany(Cohort::class);
    }

    public function trainer()
    {
        return $this->belongsToMany(Trainer::class, 'user_id');
    }

    public function learners()
    {
        return $this->hasManyThrough(Learner::class, Cohort::class);
    }

}
