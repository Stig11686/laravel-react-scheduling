<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trainer(){
        return $this->belongsTo(Trainer::class);
    }

    public function employer(){
        return $this->user->belongsTo(Employer::class, 'employer_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
