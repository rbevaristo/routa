@extends('layouts.app')
@section('styles')
    <style>
        #message {
            display: none;
        }
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
    </style>
@endsection

@section('content')
<section id="register">
    <div class="container d-flex justify-content-center h-100 align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white"><strong><span>Company</span> Registration</strong></div>
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}" onsubmit="validate()">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-building-o"></i></div>
                                </div>
                                <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required placeholder="Company Name...">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                </div>
                                <input type="email" id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required placeholder="Email...">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-user-secret"></i></div>
                                </div>
                                <input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required placeholder="Password...">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-user-secret"></i></div>
                                </div>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password...">
                            </div>
                        </div>
                        
                        <div class="form-group" id="message">
                            <small>
                            <p>Password must contain the following:</p>
                            <ul style="list-style:none">
                                <li id="letter" class="invalid">A <b>lowercase</b> letter</li>
                                <li id="capital" class="invalid">A <b>capital (uppercase)</b> letter</li>
                                <li id="number" class="invalid">A <b>number</b></li>
                                <li id="length" class="invalid">Minimum <b>8 characters</b></li>
                            </ul>
                            </small>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-round btn-md form-control">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@include('scripts.pwdvalidation')
@endsection