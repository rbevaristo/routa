@extends('layouts.company')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/components/lib/bootstrap-toggle.min.css') }}">
@endsection
@section('content')
@if(session('success2'))
    <div class="alert alert-success notice notice-success notice-sm" role="alert">
        <strong><span class="fa fa-check"></span></strong>{{ session('success') }}
        Click <a href="{{ asset('storage/pdf/') }}/{{ \App\EvaluationFile::where('user_id', auth()->user()->id)->latest('id')->first()->filename }}" target="_blank"> here </a> to view file.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="fa fa-window-close"></i>
            </span>
        </button>
    </div>
@endif
<div class="container-fluid">
    <div class="row">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="author text-center">
                        <a href="#">
                            <img class="avatar border-gray" src="{{ asset('storage/images/') }}/{{ auth()->user()->profile->avatar }}" alt="Avatar" width="70" height="70">
                            <h5 class="name"><a href="#">{{ auth()->user()->name }}</a></h5>
                        </a>
                        <p class="text-black">{{ auth()->user()->email }}</p>
                        <p class="text-primary"><strong>{{ auth()->user()->code }}</strong></p>
                        <p class="text-black">{{ auth()->user()->role->name}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="list-group">
                        <div class="list-group-item bg-primary text-white">
                            Managers
                            <span class="float-right" style="position:absolute; right: 130px; top: 5px;">
                                <form>
                                    <div class="input-group">
                                        <input class="form-control border-secondary py-2" type="search" id="search" placeholder="Search...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fa fa-search text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </span>
                            <span class="float-right">
                                <button id="add-manager" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-user-plus" data-toggle="tooltip" data-placement="top" title="Add Manager"></i></button>
                                <button id="activate-all" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Activate All">A</button>
                                <button id="deactivate-all" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Deactivate All">D</button>
                            </span>
                        </div>

                        <div id="accordianId" role="tablist" aria-multiselectable="true">
                        @if(count(auth()->user()->managers) > 0)
                            @foreach(auth()->user()->managers as $manager)
                            <div class="card">
                                <div class="card-header" role="tab" id="section1HeaderId">
                                    <img class="avatar border-gray" src="{{ asset('storage/images/') }}/{{ $manager->profile->avatar }}" alt="Avatar" width="20" height="20">
                                    <a data-toggle="collapse" data-parent="#accordianId" href="#section{{ $manager->id }}ContentId" aria-expanded="true" aria-controls="section2ContentId">
                                    {{ $manager->firstname }} {{ $manager->lastname }}
                                    </a>
                                    <span>
                                        <a href="#myModal" class="profile" data-toggle="modal" role="button" id="{{ $manager->id }}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></a>
                                        {{-- <a href="#myModal" class="evaluation" data-toggle="modal" role="button" id="{{ $manager->id }}"><i class="fa fa-bar-chart" data-toggle="tooltip" data-placement="top" title="Evaluate"></i></a> --}}
                                        @if($file = auth()->user()->evaluation_files->where('manager_id', $manager->id)->sortByDesc('created_at')->first())
                                            @php
                                                $det = date_diff(date_create(date('Y-m-d')), date_create(date('Y-m-d', strtotime($file->created_at))))->d;
                                            @endphp
                                            @if($det >= 30)
                                                <a href="#myModal" class="evaluation" data-toggle="modal" role="button" id="{{ $manager->id }}">
                                                    <i class="fa fa-bar-chart" data-toggle="tooltip" data-placement="top" title="Evaluate"></i>
                                                </a>
                                            @else
                                            <a href="#" class="evaluation" data-toggle="modal" role="button">
                                                    <i class="fa fa-bar-chart" data-toggle="tooltip" data-placement="top" title="This employee has been evaluated for this month."></i>
                                                </a>
                                            @endif
                                        @else
                                        <a href="#myModal" class="evaluation" data-toggle="modal" role="button" id="{{ $manager->id }}">
                                                <i class="fa fa-bar-chart" data-toggle="tooltip" data-placement="top" title="Evaluate"></i>
                                            </a>
                                        @endif
                                    </span>
                                    <span class="float-right">
                                        <input type="checkbox" class="act" data-toggle="toggle" data-size="small" value="{{ $manager->id }}" {{ ($manager->active) ? 'checked' : '' }}>
                                    </span>
                                </div>
                                <div id="section{{ $manager->id }}ContentId" class="collapse in" role="tabpanel" aria-labelledby="section1HeaderId">
                                    <div class="card-body">
                                        <div class="row small">
                                            <div class="col-md-6" style="height: 300px; overflow-y: auto;">
                                                <div class="list-group">
                                                    <div class="list-group-item active">
                                                        Employees
                                                        <span class="float-right dropdown">
                                                            <a href="#" class="text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-gear"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal2">Transfer</a>
                                                            </div>
                                                        </span>
                                                    </div>
                                                @if(count($manager->employees) > 0)
                                                    @foreach($manager->employees->sortBy('lastname')->sortBy('position_id') as $employee)
                                                    <div class="list-group-item">
                                                    <input type="checkbox" class="emp" id="{{ $employee->id }}">
                                                    <img class="avatar border-gray" src="{{ asset('storage/images/') }}/{{ $employee->profile->avatar }}" alt="Avatar" width="20" height="20">
                                                    {{ $employee->firstname }} {{ $employee->lastname }} <small>({{ $employee->position->name }})</small>
                                                    <span>
                                                        <a href="#myModal" class="eprofile" data-toggle="modal" role="button" id="{{ $employee->id }}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></a>
                                                    </span>
                                                    </div>
                                                    @endforeach
                                                @else
                                                <div class="list-group-item">
                                                    No Employee
                                                </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="height: 300px; overflow-y: auto;">
                                                <div class="list-group">
                                                    <div class="list-group-item bg-warning">
                                                        Schedules
                                                    </div>
                                                    @if(count($manager->schedule_files) > 0)
                                                        @foreach($manager->schedule_files->sortByDesc('created_at') as $files)
                                                        <div class="list-group-item">
                                                            <a href="{{ asset('storage/schedule/') }}/{{ $files->filename }}" target="_blank">
                                                                {{ $files->filename }}
                                                            </a>
                                                            <span class="float-right">
                                                                {{ date('F d, Y', strtotime($files->created_at)) }}
                                                            </span>
                                                        </div>
                                                        @endforeach
                                                    @else 
                                                    <div class="list-group-item">
                                                        No Files
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="card">
                                <div class="card-header">
                                    No Employee
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title " id="exampleModalLongTitle">
                    Add Employee
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                    <small>
                        <div class="alert alert-info">
                        Added employees will be provided an account automatically. The following are the credentials employees can use to access their accounts:
                        <ul>
                            <li>Username:<strong class="text-primary"> Company Code ({{ auth()->user()->code }}) + Employee ID ({{ auth()->user()->code }}-000001)</strong></li>
                            <li>Password:
                                <ul>
                                    <li> <strong class="text-primary">CASE SENSITIVE</strong></li>
                                    <li> <strong class="text-primary">1ST</strong> letter of their firstname (lowercase)</li>
                                    <li> <strong class="text-primary">Full</strong> lastname (lowercase)</li>
                                    <li> <strong class="text-primary">LAST TWO</strong> characters of their Employee ID </li>
                                </ul>
                            </li>
                        </ul>
                        </div>
                    </small>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('manager.create') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                                    </div>
                                        <input type="text" id="username" name="username" class="form-control form-control-sm" placeholder="Employee ID" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" id="firstname" name="firstname" class="form-control form-control-sm" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" id="lastname" name="lastname" class="form-control form-control-sm" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                    </div>
                                    <input type="text" id="email" name="email" class="form-control form-control-sm" placeholder="Email (optional)">
                                </div>
                            </div>
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade small" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title " id="exampleModalLongTitle">
                    Add Employee
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade small" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title " id="exampleModalLongTitle">
                        Transfer Employee
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="result">
                    <form>
                        <select name="transfer" id="transfer" class="form-control">
                            @foreach(auth()->user()->managers as $manager)
                                <option value="{{ $manager->id }}">{{ $manager->firstname }} {{ $manager->lastname }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="transferBtn" class="btn btn-primary">Transfer</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('js/components/lib/bootstrap-toggle.min.js') }}"></script>
@include('scripts.companydashboard')
@endsection