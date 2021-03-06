<?php

namespace App\Http\Controllers\Manager;

use PDF;
use App\Employee;
use App\EvaluationFile;
use App\EvaluationResult;
use App\EvaluationComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $request['emp_id'] = $id;
        $request['manager_id'] = auth()->user()->id;
        $eval = EvaluationResult::create($request->all());
        
        $comment = EvaluationComment::create([
            'qualities' => $request->qualities,
            'improvements' => $request->improvements,
            'comments' => $request->comments,
            'eval_id' => $eval->id
        ]);
        
        $data = [
            'user' => auth()->user(),
            'company' => auth()->user()->user,
            'profile' => auth()->user()->user->profile,
            'address' => auth()->user()->user->profile->address->number.' '.
            auth()->user()->user->profile->address->street.' '.
            auth()->user()->user->profile->address->city.' '.
            auth()->user()->user->profile->address->state.' '.
            auth()->user()->user->profile->address->zip.' '.
            auth()->user()->user->profile->address->country,
            'employee' => Employee::find($id),
            'results' => [
                'Quality of Work' => $eval->Quality_of_Work,
                'Efficiency of Work' => $eval->Efficiency_of_Work,
                'Dependability' => $eval->Dependability,
                'Job Knowledge' => $eval->Job_Knowledge,
                'Attitude' => $eval->Attitude,
                'Housekeeping' => $eval->Housekeeping,
                'Reliability' => $eval->Reliability,
                'Personal Care' => $eval->Personal_Care,
                'Judgement' => $eval->Judgement,
            ],
            'comments' => $comment
        ];
        $employee = Employee::find($id);
        $name = $employee->firstname.'_'.$employee->lastname.'_'.date('mdy').time().'.pdf';
        $pdf = PDF::loadView('pdf.manager.evaluation', compact('data'));
        Storage::put('public/pdf/'.$name, $pdf->output());
        //return $pdf->download($name); 
        EvaluationFile::create([
            'filename' => $name,
            'emp_id' => $id,
            'manager_id' => auth()->user()->id
        ]);
        Session::flash('download', $name);
        return redirect()->back()->with('success', "Evaluation success ");
        
    }

    public function update_status(Request $request)
    {
        $update = EvaluationFile::where('id', $request->id)->first();
        $update->active = $request->status;
        $update->save();

        if(!$update){
            return response()->json(['success' => false, 'message' => $update]);
        }

        // if($user = Employee::find($update->emp_id)){
        //     $user->notify(new EvaluationNotification(EvaluationFile::latest('id')->first()));
        // }
        return response()->json(['success' => true, 'message' => $update]);
    }
}
