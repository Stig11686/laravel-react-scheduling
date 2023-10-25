<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'cohort_id'];

    public function sessions(){
       return $this->belongsToMany(Session::class)->withPivot(['date', 'trainer_id', 'zoom_room_id'])->using(InstanceSession::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function cohort(){
        return $this->hasOne(Cohort::class, 'id', 'cohort_id');
    }

    function instanceSessions(){
        return $this->hasMany(InstanceSession::class)->orderBy('date');
    }

    public function learners()
    {
        return $this->hasMany(Learner::class);
    }

}
