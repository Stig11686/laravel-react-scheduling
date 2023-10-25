<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TrainerCollection;
use App\Http\Controllers\Controller;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TrainerCollection( Trainer::with('user')->get() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //TODO - Validate dbs_date - this can currently exists even if trainer does not have a DBS

       $request->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);

        Trainer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'status' => $request->input('status') === 'on' ? 1 : 0,
            'profile_pic' => $request->input('profile_pic'),
            'has_dbs' => $request->input('has_dbs') === 'on' ? 1 : 0,
            'dbs_date' => $request->input('dbs_date'),
            'dbs_cert_path' => $request->input('dbs_cert_path'),
            'has_completed_mandatory_training' => $request->input('has_completed_mandatory_training') === 'on' ? 1 : 0,
            'mandatory_training_cert_1' => $request->input('mandatory_training_cert_1')
        ]);

        return redirect()->route('trainers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        $sessions = DB::table('instance_session')
                            ->join('sessions', 'sessions.id', '=', 'instance_session.session_id')
                            ->join('zoom_rooms', 'zoom_rooms.id', '=', 'instance_session.zoom_room_id')
                            ->join('cohorts', 'cohorts.id', '=', 'instance_session.cohort_id')
                            ->where('trainer_id', $trainer->id)
                            ->select(['sessions.name AS session_name', 'date', 'zoom_rooms.link AS zoom_room_link', 'cohorts.name AS cohort_name'])
                            ->orderBy('date')
                            ->get();

        return view('trainers.show', compact('sessions', 'trainer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        return view('trainers.edit', compact('trainer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);

        if($request->input('has_dbs') === 'on'){
            $request->validate([
                'dbs_date_active' => 'required',
                'dbs_cert_path' => 'required'
            ]);
        }

        $trainer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'status' => $request->input('status') === 'on' ? 1 : 0,
            'profile_pic' => $request->input('profile_pic'),
            'has_dbs' => $request->input('has_dbs') === 'on' ? 1 : 0,
            'dbs_date' => $request->input('dbs_date'),
            'dbs_cert_path' => $request->input('dbs_cert_path'),
            'has_completed_mandatory_training' => $request->input('has_completed_mandatory_training') === 'on' ? 1 : 0,
            'mandatory_training_cert_1' => $request->input('mandatory_training_cert_1')
        ]);

        return redirect()->route('trainers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return redirect()->route('trainers');
    }
}
