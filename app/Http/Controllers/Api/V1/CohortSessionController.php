<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CohortRequest;
use App\Http\Resources\CohortCollection;
use App\Models\CohortSession;
use App\Http\Resources\CohortSessionResource;
use App\Http\Resources\InstanceCollection;
use App\Models\Cohort;
use Illuminate\Http\Request;

class CohortSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CohortRequest $request, string $id)
    {
        $session = CohortSession::find($request->id);

        if(!$session){
            return response()->json(['message' => 'No session found']);
        }

        $session->update([
            'cohort_id' => $request->input('cohort_id'),
            'session_id' => $request->input('session_id'),
            'date' => $request->input('date'),
            'zoom_room_id' => $request->input('zoom_room_id'),
            'trainer_id' => $request->input('trainer_id')
        ]);

        return response()->json([
            'data' => new InstanceCollection( Cohort::with(['course', 'cohortSession.trainer.user', 'cohortSession.zoom_room', 'cohortSession.session'])->get()),
            'message' => $session->session->name . ' updated successfully',
            ])
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000');

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CohortSession $cohort_session)
    {
        $session = CohortSession::find($cohort_session->id);

        if(!$session) {
            return response()->json(['message' => $cohort_session->id], 404);
        }

        $session->delete();

        return response()->json([
            'data' => new InstanceCollection( Cohort::with(['course', 'cohortSession.trainer.user', 'cohortSession.zoom_room', 'cohortSession.session'])->get()),
            'message' => $session->session->name . ' updated successfully',
            ])
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }
}
