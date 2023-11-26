<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Cohort;
use App\Models\Instance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CohortSessionRequest;
use App\Http\Resources\CohortSessionCollection;
use App\Http\Resources\InstanceCollection;
use App\Http\Resources\LearnerScheduleCollection;
use App\Models\CohortSession;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;



class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }


    public function index(Request $request)
    {
        $user = auth()->user();
        $scheduleData = $this->scheduleService->getScheduleForUser($user);

        return response()->json(['data' => $scheduleData, 'user' => $user])
            ->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function show(Instance $instance)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function update(CohortSessionRequest $request, $id)
    {
        $session = CohortSession::find($request->id);

        if(!$session){
            return response()->json(['message' => 'Session not found!'], 404);
        }

        $session->update([
            'cohort_id' => $request->input('cohort_id'),
            'date' => $request->input('date'),
            'session_id' => $request->input('session_id'),
            'zoom_room_id' => $request->input('zoom_room_id'),
            'trainer_id' => $request->input('trainer_id'),
        ]);

        return response()->json(['message' => $session->name . 'updated successfully', 'data' => new InstanceCollection( Cohort::with(['course', 'cohortSession.trainer.user', 'cohortSession.zoom_room', 'cohortSession.session'])->get())], 200)
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
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
