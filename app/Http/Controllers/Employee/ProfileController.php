<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeProfileRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function update(EmployeeProfileRequest $request)
    {
        // Update User's Name
        if(Employee::where('email', $request->email)->first() && auth()->user()->email != $request->email){
            return redirect()->back()->with('error', 'Email already exist');
        }
        $user = auth()->user();
        $user->update(['email' => $request->email]);

        // Update User's Profile
        $profile = auth()->user()->profile;
        $profile->avatar = $request->hasFile('file') ? $this->upload($request) : auth()->user()->profile->avatar;
        $profile->gender = $request->gender;
        $profile->birthdate = $request->birthdate;
        $profile->contact = $request->contact_number;
        $profile->gender = $request->gender;
        $profile->save();

        // Update User's Address
        $address = auth()->user()->profile->address;
        $address->number = $request->number;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->zip = $request->zip;
        $address->save();

        if($user && $profile && $address)
            return redirect()->back()->with('success', 'Profile Updated!!');
        return redirect()->back()->with('error', 'Error Updating Please Check Your Inputs');
        
    }

    public function upload(Request $request) 
    {

        $filenameWithExt = $request->file('file')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        $extension = $request->file('file')->getClientOriginalExtension();
        
        $fileNameToStore = $filename.'_'.time().date('mdY').'.'.$extension;
        
        $path = $request->file('file')->storeAs('public/images', $fileNameToStore);

        return $fileNameToStore;

    }
}
