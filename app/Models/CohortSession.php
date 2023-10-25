<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CohortSession extends Model
{
    use HasFactory;

    public $table = 'cohort_session';

    public function trainer(){
        return $this->belongsTo(Trainer::class);
    }

    public function zoom_room(){
        return $this->belongsTo(ZoomRoom::class);
    }

    public function cohort(){
        return $this->belongsTo(Cohort::class);
    }

    public function session(){
        return $this->belongsTo(Session::class);
    }
}
