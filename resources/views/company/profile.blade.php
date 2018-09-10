@extends('layouts.company')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/components/lib/jquery-countryselector.css') }}">
@endsection
@section('content')
<section id="user-profile">
    <div class="container-fluid">
        <div class="row text-black" id="user-profile">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img class="avatar border-gray" src="{{ asset('storage/images/') }}/{{ auth()->user()->profile->avatar }}" alt="Avatar" width="70" height="70">
                            <h5 class="text-primary">{{ auth()->user()->name }}</h5>
                            <p> <small>{{ auth()->user()->email }} </small></p>
                            <p> {{ auth()->user()->code }}</p>
                            <p> <strong>{{ auth()->user()->role->name}} </strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Edit Profile
                    </div>
                    <div class="card-body">
                    <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Profile Picture</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".jpg,.gif,.png,.jpeg">
                                        <label class="custom-file-label" for="customFile">Choose Image</label>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                        <hr>
                        <div class="row">
                            <div class="col-md-6 px-1">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-phone"></i></div>
                                        </div>
                                        <input type="number" class="form-control" id="contact_number" name="contact_number" value="{{ auth()->user()->profile->contact }}" placeholder="Contact Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h3>Address</h3>
                            </div>
                        </div>
                       <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-hashtag"></i></div>
                                        </div>
                                        <input type="text" id="number" name="number" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" value="{{ auth()->user()->profile->address->number }}" placeholder="House Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-road"></i></div>
                                        </div>
                                        <input type="text" id="street" name="street" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" value="{{ auth()->user()->profile->address->street }}" placeholder="Street">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-building"></i></div>
                                        </div>
                                        <input type="text" id="city" name="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" value="{{ auth()->user()->profile->address->city }}" placeholder="City">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-marker"></i></div>
                                        </div>
                                        <input type="text" id="state" name="state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" value="{{ auth()->user()->profile->address->state }}" placeholder="State">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin"></i></div>
                                        </div>
                                        <input type="text" id="zip" name="zip" class="form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}" value="{{ auth()->user()->profile->address->zip }}" placeholder="Zip Code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-flag"></i></div>
                                        </div>
                                        <select class="form-control" name="country" id="country" data-role="country-selector" value="{{ auth()->user()->profile->address->country }}"></select>
                                        {{-- <input type="text" id="country" name="country" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" value="{{ auth()->user()->profile->address->country }}" placeholder="Country"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary form-control">Save</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection

@section('scripts')
    <script src="{{ asset('js/components/lib/jquery.countrySelector.js') }}"></script>
    <script>
        $(document).ready(() => {
            $('.custom-file-input').on('change', function() { 
                let fileName = $(this).val().split('\\').pop(); 
                $(this).next('.custom-file-label').addClass("selected").html(fileName); 
            });
        });
        
    </script>
@endsection