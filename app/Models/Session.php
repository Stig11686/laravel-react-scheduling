<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'review_due', 'review_status', 'slides', 'trainer_notes'];

    public function cohorts()
    {
        return $this->belongsToMany(Cohort::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
