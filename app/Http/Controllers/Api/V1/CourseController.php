<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;

class CourseController extends Controller {

    public function index(){
        // Retrieve courses with cohorts relationship
        $courses = Course::with('cohorts.learners')->paginate(10);
    
        // Calculate the learner count for each course
        $courseLearnerCounts = $courses->map(function ($course) {
            return [
                'course_id' => $course->id,
                'learner_count' => $course->cohorts->sum(function ($cohort) {
                    return $cohort->learners->count();
                }),
            ];
        })->keyBy('course_id');
    
        // Merge learner count with each course
        $courses->each(function ($course) use ($courseLearnerCounts) {
            $course->learner_count = $courseLearnerCounts[$course->id]['learner_count'] ?? 0;
        });
    
        $courseCollection = new CourseCollection($courses);
    
        return response()->json([
            'data' => $courseCollection,
            'pagination' => [
                'total' => $courseCollection->total(),
                'per_page' => $courseCollection->perPage(),
                'current_page' => $courseCollection->currentPage(),
                'last_page' => $courseCollection->lastPage(),
                'from' => $courseCollection->firstItem(),
                'to' => $courseCollection->lastItem()
            ]
        ])->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    public function show(Course $course){
        return response()->json(['data' => new CourseResource( $course )]);
    }

    public function store(CourseRequest $request){

        $course = new Course();
        $course->name = $request->input('name');

        $course->save();

        return response()->json(['message' => 'Course created successfully', 'data' => $course]);
    }

    public function update(CourseRequest $request){
        $course = Course::find($request->id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->update([
            'name' => $request->input('name')
        ]);

        return response()->json(['data' => $course], 200);

    }

    public function destroy(Course $course){
        $course = Course::find($course->id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();

        $courses = Course::all();

        return response()->json(['message' => 'Course deleted successfully', 'data' => new CourseCollection( Course::all())]);

    }

    public function allCourses(){
        $courses = Course::all(['id', 'name']);

        return response()->json(['data' => $courses]);
    }

}
