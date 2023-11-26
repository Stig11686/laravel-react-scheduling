<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionRequest;
use App\Http\Resources\SessionCollection;
use App\Http\Resources\SessionResource;
use App\Models\Session;

class SessionController extends Controller {

    public function index(){
        $sessions = Session::with('tasks')->paginate(25);
        $sessionsCollection = new SessionCollection($sessions);

        return response()->json([
            'data' => $sessionsCollection,
            'pagination' => [
                'total' => $sessions->total(),
                'per_page' => $sessions->perPage(),
                'current_page' => $sessions->currentPage(),
                'last_page' => $sessions->lastPage(),
                'from' => $sessions->firstItem(),
                'to' => $sessions->lastItem()
            ]
        ])->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    public function show(Session $session){
        return response()->json(['data' => new SessionResource( $session )])
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000');
    }

    public function update(SessionRequest $request){
        $session = Session::find($request->id);

        if (!$session) {
            return response()->json(['message' => 'Session not found'], 404);
        }

        $session->update([
            'name' => $request->input('name'),
            'trainer_notes' => $request->input('trainer_notes'),
            'slides' => $request->input('slides'),
            'review_status' => $request->input('review_status'),
            'review_due' => $request->input('review_due')
        ]);

        $session->tasks()->sync($request->input('array_selected_id', []));

        $session->load('tasks');

        return response()->json(['message' => $session->name . ' updated successfully', 'data' => new SessionResource( $session )], 200);

    }

    public function destroy(Session $session){
        $session = Session::find($session->id);

        if (!$session) {
            return response()->json(['message' => 'Session not found'], 404);
        }

        $session->delete();

        $sessions = Session::all();

        return response()->json(['message' => 'Session deleted successfully', 'data' => new SessionCollection( Session::paginate(10))]);

    }


    private function slugify($text, string $divider = '-'){
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
