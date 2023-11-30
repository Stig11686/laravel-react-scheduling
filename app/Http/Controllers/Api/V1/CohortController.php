<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CohortRequest;
use App\Http\Resources\CohortCollection;
use App\Http\Resources\CohortResource;
use App\Models\Cohort;

class CohortController extends Controller {

    public function index(){
        $cohorts = Cohort::paginate(10);
        $cohortCollection = new CohortCollection($cohorts);

        return response()->json([
            'data' => $cohortCollection,
            'pagination' => [
                'total' => $cohorts->total(),
                'per_page' => $cohorts->perPage(),
                'current_page' => $cohorts->currentPage(),
                'last_page' => $cohorts->lastPage(),
                'from' => $cohorts->firstItem(),
                'to' => $cohorts->lastItem()
            ]
        ])->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    public function show(Cohort $cohort){
        return response()->json(['data' => new CohortResource( $cohort )])
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    public function store(CohortRequest $request){
        $cohort = new Cohort();
        $cohort->name = $request->name;
        $cohort->course_id = $request->course_id;
        $cohort->start_date = $request->start_date;
        $cohort->end_date = $request->end_date;
        $cohort->places = $request->places;

        $cohort->save();

        return response()->json(['data' => new CohortResource($cohort), 'message' => 'Cohort successfully created', 'api_test' => 'changed received from github action!']);
    }

    public function update(CohortRequest $request){
        $cohort = Cohort::find($request->id);

        if (!$cohort) {
            return response()->json(['message' => 'Cohort not found'], 404);
        }

        $cohort->update([
            'name' => $request->input('name'),
            'course_id' => $request->input('course_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'place' => $request->input('places')
        ]);

        return response()->json(['message' => 'Cohort Updated Successfully', 'data' => new CohortResource( $cohort )], 200);

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
