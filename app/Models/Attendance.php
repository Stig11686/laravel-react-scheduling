<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance'; 

    protected $fillable = ['learner_id', 'session_id', 'status'];

    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    public function session()
    {
        return $this->belongsTo(CohortSession::class, 'session_id');
    }
}
