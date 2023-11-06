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
use Illuminate\Support\Facades\Auth;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
{

    $user = auth()->user();

    //$schedule = Cohort::with(['course', 'cohortSession.trainer.user', 'cohortSession.zoom_room', 'cohortSession.session'])->get();
    $schedule = [];


    if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
        // For super-admins and admins, return the full schedule
        $schedule = Cohort::with(['course', 'cohortSession.trainer.user', 'cohortSession.zoom_room', 'cohortSession.session'])->get();
    } elseif ($user->hasRole('trainer')) {
        $schedule = CohortSession::with(['cohort', 'trainer.user', 'cohort.course', 'zoom_room', 'session'])->where(
            'trainer_id', $user->trainer->id
            )
        ->get()
        ->groupBy('cohort_id');

        $formattedSchedule = $schedule->map(function ($cohortSessions) {
            // Assuming each group of cohortSessions contains sessions from the same cohort
            $firstSession = $cohortSessions->first(); // Get the first session to extract common cohort data
            return [
                'cohort_id' => $firstSession->cohort->id,
                'cohort_name' => $firstSession->cohort->name,
                'course_name' => $firstSession->cohort->course->name,
                'sessions' => $cohortSessions->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'session_id' => $session->session_id,
                        'date' => $session->date,
                        'session_name' => $session->session->name,
                        'slides' => $session->session->slides,
                        'trainer_notes' => $session->session->trainer_notes,
                        // 'zoom_room' => [
                        //     'id' => $session->zoom_room->id,
                        //     'name' => $session->zoom_room->name,
                        //     'link' => $session->zoom_room->link,
                        // ],
                        // Add more session details as needed
                    ];
                }),
            ];
        });

        $formattedScheduleArray = $formattedSchedule->values()->all();


        return response()->json(['data' => $formattedScheduleArray]);
    } elseif ($user->hasRole('learner')) {
        // For learners, return the schedule where they are enrolled
        $schedule = Cohort::whereHas('learners', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['course', 'cohortSession.trainer.user', 'cohortSession.zoom_room', 'cohortSession.session'])->get();

        return response()->json(['data' => new LearnerScheduleCollection($schedule), 'user' => $user])
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    return response()->json(['data' => new InstanceCollection($schedule), 'user' => $user])
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
