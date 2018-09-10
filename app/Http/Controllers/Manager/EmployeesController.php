<?php

namespace App\Http\Controllers\Manager;

use App\Employee;
use PasswordMaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function store(EmployeeRequest $request) 
    {
        $employee = new Employee;
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->username = auth()->user()->user->code.'-'.$request->username;
        $employee->email = $request->email;
        $pwd = new PasswordMaker;
        $employee->password = $pwd->makePassword($request->firstname, $request->lastname, $request->username);
        $employee->position_id = $request->position_id;
        $employee->manager_id = auth()->user()->id;
        $employee->save();
        
        if($employee) {
            $profile = \App\Profile::create(['emp_id' => $employee->id]);
            $address = \App\Address::create(['profile_id' => $profile->id]);
            $preference = \App\Preference::create(['emp_id' => $employee->id]);
            return redirect()->back()->with('success', 'Employee Added');
        }

        return redirect()->back()->with('error', 'Error Adding');
    }

    public function update_status(Request $request)
    {
        $update = Employee::where('id', $request->id)->first();
        $update->active = $request->status;
        $update->save();

        if(!$update){
            return response()->json(['success' => false, 'message' => $update]);
        }
        return response()->json(['success' => true, 'message' => $update]);
    }

    public function upload(Request $request)
    {
        $upload = $request->file('excelfile');
        $filePath = $upload->getRealPath();
        $file = fopen($filePath, 'r');

        $header = fgetcsv($file);

        $columns = [];
        //dd($header);
        foreach($header as $key => $value){
            $column = strtolower($value);
            $items = preg_replace('/[^a-z]/', '', $column);
            if($column == 'id' || $column == 'firstname' || $column == 'lastname' || $column == 'position' || $column == 'email')
                array_push($columns, $items);
            else
                 return redirect()->back()->with('error', 'Column '.$value.' does not exist on storage');
        }
        $err = [];
        while($datas = fgetcsv($file))
        {
            if($datas[0]=="")
                continue;

            $data = array_combine($columns, $datas);

            $id=$data['id'];
            $firstname=$data['firstname'];
            $lastname=$data['lastname'];
            $position=$data['position'];
            $email=($data['email'] == '') ? null : $data['email'];

            $d = Employee::where('username', auth()->user()->user->code.'-'.$id)->first();
            
            if(!$d && strlen($id) >= 5 && $this->checkEmail($email)){
                $d = new Employee;
                $d->username = auth()->user()->user->code.'-'.$id;
                $d->firstname = $firstname;
                $d->lastname = $lastname;
                $d->email = $email;
                $pwd = new PasswordMaker;
                $d->password = $pwd->makePassword($firstname, $lastname, $id);
                $d->manager_id = auth()->user()->id;
                if($p = \App\Position::where('name', $position)->first()){
                    $d->position_id = $p->id;
                } else {
                    $p = \App\Position::create(['name' => $position, 'user_id' => auth()->user()->id]);
                    $d->position_id = $p->id;
                }
                
                $d->save();
                if($d) {
                    $profile = \App\Profile::create(['emp_id' => $d->id]);
                    $address = \App\Address::create(['profile_id' => $profile->id]);
                    $preference = \App\Preference::create(['emp_id' => $d->id]);
                }
            } elseif($d && strlen($id) >= 5) {
                $err[] = 'Employee ID: ' . $d->username . ' already exist in storage.';
            } elseif(!$this->checkEmail($email)) {
                $err[] = 'Invalid Email';
            } else {
                $err[] = 'Employee ID:'. $id .' is less than 5 characters';
            }
            
        }
        if(sizeof($err) > 0){
            return redirect()->back()->with('error', 'Error adding employees either Employee ID is less than 5 characters or the ID is existing or Email is invalid');
        }

        return redirect()->back()->with('success', 'Employees Added');
    }

    public function get_job(Request $request)
    {
        return response()->json([
            'data' => Position::where('id', $request->id)->first()->name
        ]);
    }

    public function update_all(Request $request)
    {
        $update = DB::table('employees')->where('manager_id', auth()->user()->id)->update(['active' => $request->val]);
        if($update){
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function checkEmail($email)
    {  
        if($email == null){
            return true;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; 
        }

        return true;
    }
}
