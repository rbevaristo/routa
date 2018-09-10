<?php

namespace App\Http\Controllers;

use App\Manager;
use PasswordMaker;
use App\EvaluationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ManagerRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EvaluationCollection;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ManagerRequest $request)
    {
        $pwd = new PasswordMaker;
        $user = Manager::create([
            'username' => auth()->user()->code .'-'.$request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $pwd->makePassword($request->firstname, $request->lastname, $request->username),
            'user_id' => auth()->user()->id,
            'position_id' => 1,
        ]);

        if($user) {
            $profile = \App\Profile::create(['man_id' => $user->id]);
            $address = \App\Address::create(['profile_id' => $profile->id]);
            $setting = \App\Setting::create(['user_id' => $user->id]);
            $criteria = \App\Criteria::create(['user_id' => $user->id]);
            return redirect()->back()->with('success', 'Add Success!');
        } 
        return redirect()->back()->with('error', 'Error processing request');
    }

    public function edit(Request $request)
    {
        $update = Manager::where('id', $request->id)->first();
        $update->active = $request->status;
        $update->save();

        if(!$update){
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $user = Manager::where('id', $id)->first();
        $evaluation = EvaluationFile::all()->where('manager_id', $id)->sortByDesc('id');   
        if($user) {
            return response()->json([
                'data' => new EmployeeResource($user),
                'evaluation' => new EvaluationCollection($evaluation),
            ]);
        }

        return response()->json(['data' => null]);
    }

    public function update_all(Request $request)
    {
        $update = DB::table('managers')->where('user_id', auth()->user()->id)->update(['active' => $request->val]);
        if($update){
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
