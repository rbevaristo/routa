<?php

namespace App\Http\Controllers;

use PDF;
use App\Manager;
use App\EvaluationFile;
use App\EvaluationResult;
use App\EvaluationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $request['manager_id'] = $id;
        $request['user_id'] = auth()->user()->id;
        $eval = EvaluationResult::create($request->all());
        
        $comment = EvaluationComment::create([
            'qualities' => $request->qualities,
            'improvements' => $request->improvements,
            'comments' => $request->comments,
            'eval_id' => $eval->id
        ]);
        
        $data = [
            'user' => auth()->user(),
            'company' => auth()->user()->profile,
            'address' => auth()->user()->profile->address,
            'manager' => Manager::find($id),
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
        $employee = Manager::find($id);
        $name = $employee->firstname.'_'.$employee->lastname.'_'.date('mdy').time().'.pdf';
        $pdf = PDF::loadView('pdf.evaluation', compact('data'));
        Storage::put('public/pdf/'.$name, $pdf->output());
        
        EvaluationFile::create([
            'filename' => $name,
            'manager_id' => $id,
            'user_id' => auth()->user()->id
        ]);
        //return $pdf->download($name);
        Session::flash('download', $name);
        return redirect()->back()->with('success2', "Evaluation success ");
        
    }
}
