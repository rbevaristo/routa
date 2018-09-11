<?php

namespace App\Http\Controllers\API\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api2');
    }

    public function schedule()
    {
        $sched = auth()->user()->schedule;

        if($sched){
            $s = json_decode($sched->schedule);
            //rsort($s);
            return response()->json(['data' => $s]);
        }
        

        return response()->json(['data' => '']);
    }
}
