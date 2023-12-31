<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    function learners(){
        return $this->hasMany(Learner::class);
    }

    public function managers()
    {
        return $this->hasMany(User::class)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'manager');
            });
    }

    public function mentors()
    {
        return $this->hasMany(User::class)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'mentor');
            });
    }
}
