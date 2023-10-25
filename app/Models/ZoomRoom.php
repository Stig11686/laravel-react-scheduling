<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomRoom extends Model
{
    use HasFactory;

    protected $table = 'zoom_rooms';

    protected $fillable = ['name', 'link'];
}
