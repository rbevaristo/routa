<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\VerifyUser;
use App\Mail\VerifyAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'code' => $this->getCode(),
        ]);

        if($user) {
            $verify = \App\VerifyUser::create(['user_id' => $user->id, 'token' => str_random(40)]);
            $profile = \App\CompanyProfile::create(['user_id' => $user->id]);
            $address = \App\Address::create(['company_id' => $profile->id]);
            Mail::to($user->email)->send(new VerifyAccount($user));
        }

        return $user;
    }

    public function getCode()
    {
        $code = str_random(2);
        $user = User::where('code', $code)->first();
        if($user){
            while($user->code == $code)
            {
                $code = str_random(2);
            }
        }        
        return strtoupper($code);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath())->with('success', 'Please check your email and verify your account.');
    }

    public function verify($token) 
    {
        $user = VerifyUser::where('token', $token)->first();
        User::where('id', $user->user_id)->update([
            'verified' => true,
        ]);

        if($user){
            return redirect('login/admin')->with('success', 'Congratulations! you may now login');
        }

        return redirect('login/admin')->with('error', 'Something wrong processing your request');
    }
}
