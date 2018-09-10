<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EvaluationFile;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EvaluationCollection;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = Employee::where('id', $id)->first();
        $evaluation = EvaluationFile::all()->where('emp_id', $id)->sortByDesc('id');   
        if($user) {
            return response()->json([
                'data' => new EmployeeResource($user),
                'evaluation' => new EvaluationCollection($evaluation),
            ]);
        }

        return response()->json(['data' => null]);
    }
}
