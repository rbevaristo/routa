<?php

namespace App\Http\Controllers\API\Employee;

use App\Manager;
use App\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\RequestsNotification;

class UserRequestController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api2');
    }

    public function send(Request $request)
    {

        $req = new UserRequest;
        $req->emp_id = auth()->user()->id;
        $req->user_id = auth()->user()->manager->id;
        $req->from = $request->from;
        $req->upto = $request->to;
        $req->title = $request->title;
        $req->message = $request->message;
        $req->save();

        if(!$req) {
            return redirect()->back()->with('error', 'There is an error with your request');
        }

        if($user = Manager::find($req->user_id)){
            $user->notify(new RequestsNotification(UserRequest::latest('id')->first()));
        }

        return response()->json(['data' => 'Success!']);
    }
}
