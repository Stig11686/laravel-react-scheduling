<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;

class CourseController extends Controller {

    public function index(){
        $courses = Course::all();
        \Debugbar::info('API endpoint: /api/courses');
        return response()->json(['data' => new CourseCollection( $courses )]);
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

}
