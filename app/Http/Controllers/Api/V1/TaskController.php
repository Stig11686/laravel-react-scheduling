<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskCollection;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::all();

        return response()->json(['data' => new TaskCollection( $tasks )]);
    }
}
