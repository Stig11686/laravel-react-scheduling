<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Learner;
use App\Models\Cohort;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Inertia\Inertia;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles', 'permissions')->where('id', '<>', auth()->user()->id)->paginate(50);

        return response()->json(['data' => UserResource::collection($users)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with(['roles', 'learner.cohort'])->find($id);
        $allRoles = Role::all();
        $cohorts = Cohort::all();

        return Inertia::render('Admin/Users/UserEdit', compact('user', 'allRoles', 'cohorts'));
    }

    // public function update(Request $request){

    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255'],
    //         //'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
    //         'roles' => 'required'
    //     ]);

    //     $user = User::find($request->input('id'));
    //     $roles = $request->input('roles');
    //     $user->syncRoles([$roles]);

    //     return redirect()->back();
    // }

    public function update(Request $request)
    {
        $validatedData = $this->validateUser($request);

        $user = User::find($request->input('id'));
        $roles = $request->input('roles');
        $roleData = $this->syncRoles($user, $roles);

        if ($roleData['isTrainer']) {
            $this->addTrainer($user);
        } else {
            $this->removeTrainer($user);
        }

        if ($roleData['isLearner']) {
            $this->addLearner($user);
        } else {
            $this->removeLearner($user);
        }

        return redirect()->back()->with('success', 'User updated successfully.');
    }



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users');
    }

    private function validateUser(Request $request)
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'roles' => 'required'
        ]);
    }

    private function syncRoles(User $user, array $roles)
    {
        $user->syncRoles([$roles]);

        return [
            'isTrainer' => in_array(3, $roles),
            'isLearner' => in_array(4, $roles),
        ];
    }

    private function addTrainer(User $user)
    {
        if (!$user->trainer) {
            $trainer = new Trainer();
            $trainer->user_id = $user->id;
            $trainer->save();
        }
    }

    private function removeTrainer(User $user)
    {
        $user->trainer()->delete();
    }

    private function addLearner(User $user)
    {
        if (!$user->learner) {
            $learner = new Learner();
            $learner->user_id = $user->id;
            $learner->save();
        }
    }

    private function removeLearner(User $user)
    {
        $user->learner()->delete();
    }



}
