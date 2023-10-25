<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class InstanceSession extends Pivot
{
    use HasFactory;

    protected $table = 'instance_session';

    protected $fillable = ['instance_id', 'session_id', 'date', 'trainer_id', 'zoom_room_id', 'cohort_id' ];

    public function instance(){
        return $this->belongsTo(Instance::class);
    }

    public function session(){
        return $this->hasOne(Session::class, 'id', 'session_id');
    }

    public function zoomRoom(){
        return $this->belongsTo(ZoomRoom::class);
    }

    // public function trainer(){
    //     return $this->hasOne(Trainer::class, 'id', 'trainer_id');
    // }

    public function trainer(){
        return $this->hasOneThrough(User::class, Trainer::class, 'id', 'id', 'trainer_id', 'user_id');
    }

    public function user(){
        return $this->hasOneThrough(Trainer::class, User::class, 'user_id');
    }

}
