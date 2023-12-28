<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CohortRequest;
use App\Http\Resources\CohortCollection;
use App\Http\Resources\CohortResource;
use App\Http\Resources\ZoomRoomCollection;
use App\Http\Resources\ZoomRoomResource;
use App\Models\Cohort;
use App\Models\ZoomRoom;

class ZoomRoomController extends Controller {

    public function index(){
        $zoom_rooms = ZoomRoom::all();

        return response()->json([
            'data' => new ZoomRoomCollection($zoom_rooms)
        ])->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    public function show(ZoomRoom $zoom_room){
        return response()->json(['data' => new CohortResource( $zoom_room )])
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    public function store(ZoomRoomRequest $request){
        $zoom_room = new ZoomRoom();
        $zoom_room->name = $request->name;
        $zoom_room->link = $request->link;

        $zoom_room->save();

        return response()->json(['data' => new ZoomRoomResource ($zoom_room), 'message' => 'Cohort successfully created']);
    }

    public function destroy(Cohort $cohort){
        $cohort = Cohort::find($cohort->id);

        if (!$cohort) {
            return response()->json(['message' => 'Cohort not found'], 404);
        }

        $cohort->delete();

        $cohorts = Cohort::all();

        return response()->json(['message' => 'Cohort deleted successfully', 'data' => new CohortCollection( Cohort::paginate(10))]);

    }

}
