<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyProfileRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('company.profile');
    }

    public function update(CompanyProfileRequest $request)
    {

        // Update User's Profile
        $profile = auth()->user()->profile;
        $profile->avatar = $request->hasFile('file') ? $this->upload($request) : auth()->user()->profile->avatar;
        $profile->contact = $request->contact_number;
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

        if($profile && $address)
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
