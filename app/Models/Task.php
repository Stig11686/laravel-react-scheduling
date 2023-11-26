<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_task', 'task_id', 'session_id');
    }

    public function learners()
    {
        return $this->belongsToMany(Learner::class);
    }
}
