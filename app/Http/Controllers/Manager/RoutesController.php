<?php

namespace App\Http\Controllers\Manager;

use App\Shift;
use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeesCollection;

class RoutesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function dashboard() {
        if(count(auth()->user()->employees) > 0){
            $employs = EmployeesCollection::collection(auth()->user()->employees->where('active', 1));
            $shifts = auth()->user()->shifts;
            $required_shifts = auth()->user()->required_shifts;
            $settings = [
                'sharing' => auth()->user()->setting->sharing, // boolean | default is 0 meaning it is off
                'dayoff' => auth()->user()->setting->dayoff, // boolean | default is 0 meaning it is off
                'shift' => auth()->user()->setting->shift, // boolean | default is 0 meaning it is off
                'days' => auth()->user()->setting->num_days, // integer | default is 7 for 1 week
                'scheddayoff' => auth()->user()->setting->sched_dayoff, // string | 0000000
                'dayoffs' => 1, // integer | default is 1 it is base from the ratio 7days:1dayoff
                'schedlock' => auth()->user()->setting->sched_lock // boolean | 
            ];

            $schedule_string = auth()->user()->scheduler; //->schedule;
            $schedule_string = $schedule_string?$schedule_string->schedule:null;

            $position_ids = Position::all();
            $shift_ids = Shift::all();

            $criteria = [
                'age' => auth()->user()->criteria->age, // boolean | default is 0 meaning it is off
                'age_value' => auth()->user()->criteria->age_value, // integer the condition will be greater than the value
                'gender' => auth()->user()->criteria->gender, // boolean | default is 0 meaning it is off
                'gender_value' => auth()->user()->criteria->gender, // boolean for male is 1 for female 0
                'name' => auth()->user()->criteria->name, // boolean | default is 0 meaning it is off
                'name_value' => auth()->user()->criteria->name_value, // boolean sort by firstname is 0 sortb by lastname is 1
            ];

            // $leave = auth()->user()->user_requests->where('approved', 1);
            
            return view('manager.dashboard', [
                'employs' => json_encode($employs),
                'shifts' => $shifts,
                'required_shifts' => $required_shifts,
                'settings' => json_encode($settings),
                'criteria' => json_encode($criteria),
                'schedule_string' => json_encode($schedule_string),
                'position_ids' => json_encode($position_ids),
                'shift_ids' => json_encode($shift_ids)
            ]);
        }
        return redirect('manager/dashboard/manage');
    }

    public function manage() {
        return view('manager.manage');
    }

    public function settings() {
        return view('manager.settings');
    }

    public function messages() {
        return view('manager.messages');
    }

    public function peformance() {
        return view('manager.performance');
    }

    public function profile() {
        return view('manager.profile');
    }

}
