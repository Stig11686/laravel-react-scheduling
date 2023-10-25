<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'places', 'start_date', 'end_date'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function sessions()
    {
        return $this->hasManyThrough(Session::class, CohortSession::class, 'cohort_id', 'id', 'id', 'session_id');
    }

    public function learners()
    {
        return $this->hasMany(Learner::class);
    }

    public function cohortSession(){
        return $this->hasMany(CohortSession::class);
    }
}
