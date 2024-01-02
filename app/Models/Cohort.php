<?php

namespace App\Models;

use App\Http\Resources\CohortSessionResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cohort extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'places', 'start_date', 'end_date'];

    public function attendance()
    {
        return $this->hasManyThrough(
            Attendance::class,
            CohortSession::class,
            'cohort_id',       // Foreign key on cohort_sessions table
            'session_id',      // Foreign key on attendances table
            'id',              // Local key on cohorts table
            'id'               // Local key on cohort_sessions table
        );
    }

    public function getAllAttendanceAttribute()
    {
        // Fetch all learners and sessions for the cohort
        $learners = $this->learners;
        $sessions = $this->cohortSession;

        // Fetch attendance records for all learners and sessions
        $attendance = Attendance::whereIn('session_id', $sessions->pluck('id'))
            ->whereIn('learner_id', $learners->pluck('id'))
            ->get();

        // Structure attendance data
        $attendanceData = [];
        foreach ($learners as $learner) {
            foreach ($sessions as $session) {
                $attendanceData[$learner->user->name][$session->session->name] = [
                    'session_id' => $session->id,
                    'session_date' => $session->date,
                    'status' => $attendance
                        ->where('session_id', $session->id)
                        ->where('learner_id', $learner->id)
                        ->first()?->status ?? ''
                    // You can add other session details if needed
                ];
            }
        }

        return $attendanceData; // Return the structured attendance data
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function sessions()
    {
        return $this->hasManyThrough(Session::class, CohortSession::class, 'cohort_id', 'id', 'id', 'session_id');
    }

    public function learners()
    {
        return $this->hasMany(Learner::class);
    }

    public function cohortSession()
    {
        return $this->hasMany(CohortSession::class)->orderBy('date', 'asc');
    }

    public function getFormattedSchedule()
    {
        return [
            'id' => $this->id,
            'course_name' => $this->course->name,
            'cohort_name' => $this->name,
            //'sessions' => CohortSessionResource::collection($this->cohortSession),
        ];
    }
}
