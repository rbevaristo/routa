<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoutesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function dashboard()
    {
        $sched = auth()->user()->schedule->schedule;

        return view('employee.dashboard',[
            'schedule' => $sched
        ]);
    }

    public function profile() {
        return view('employee.profile');
    }

    public function messages() {
        $user = auth()->user()->user;
        return view('employee.messages', compact('user'));
    }

    public function performance() {
        return view('employee.performance');
    }
}
