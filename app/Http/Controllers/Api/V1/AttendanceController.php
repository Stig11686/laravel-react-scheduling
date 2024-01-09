<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Cohort;
use App\Http\Resources\CohortWithLearnerResource;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $cohortId = $request->cohort_id;
        $cohort = Cohort::with('attendance', 'learners', 'learners.user', 'cohortSession', 'cohortSession.session')->find($cohortId);
        
        $data = $request->all();
        $attendances = [];

        foreach ($data['pendingUpdates'] as $update) {
            $attendance = Attendance::create([
                'learner_id' => $update['learner_id'],
                'session_id' => $update['session_id'],
                'status' => $update['status'],
            ]);
            $attendances[] = $attendance;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Attendance created successfully',
            'data' => new CohortWithLearnerResource($cohort),
            'created_attendances' => $attendances,
        ]);
    }

}
