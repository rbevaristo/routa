@extends('layouts.employee')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/components/schedulerstyles.css') }}">
@endsection

@section('content')
<section id="employee-dashboard">
    <div class="container-fluid">
        @if(!auth()->user()->is_reset)
            <div class="row">
                <div class="col-12">
                    <div class="alert fade show notice notice-warning" role="alert">
                        <strong> Notice </strong> 
                        Click <a href="#" data-toggle="modal" data-target="#exampleModalCenter"> here </a> 
                            to change your password
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="author text-center">
                            <a href="#">
                                <img class="avatar border-gray" src="{{ asset('storage/images/') }}/{{ auth()->user()->profile->avatar }}" alt="Avatar" width="70" height="70">
                                <h5 class="name"><a href="{{ route('employee.profile') }}">{{ Helper::name() }}</a></h5>
                            </a>
                            <p class="text-black">{{ auth()->user()->email }}</p>
                            <p class="text-black">{{ auth()->user()->position->name}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Schedules
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->manager->setting->dayoff || auth()->user()->manager->setting->shift)
                            <h2></h2>
                            <div class="row">
                            @if(auth()->user()->manager->setting->dayoff && auth()->user()->manager->setting->sched_dayoff==0)
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Dayoff</div>
                                            </div>
                                        <div class="btn-group" role="group">

                                            <button type="button" name="inactive" class="btn btn-secondary btnDays" id="0">Sun</button>
                                            <button type="button" name="inactive" class="btn btn-secondary btnDays" id="0">Mon</button>
                                            <button type="button" name="inactive" class="btn btn-secondary btnDays" id="0">Tue</button>
                                            <button type="button" name="inactive" class="btn btn-secondary btnDays" id="0">Wed</button>
                                            <button type="button" name="inactive" class="btn btn-secondary btnDays" id="0">Thu</button>
                                            <button type="button" name="inactive" class="btn btn-secondary btnDays" id="0">Fri</button>
                                            <button type="button" name="inactive" class="btn btn-secondary btnDays" id="0">Sat</button>
                                        
                                        </div>
                                    </div>
                                </div>
                            @endif 
                            @if(auth()->user()->manager->setting->shift)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Shift</div>
                                            </div>
                                            <select name="selectedShift" id="selectedShift" class="form-control">
                                                @if(auth()->user()->manager->shifts->count())
                                                    @foreach(auth()->user()->manager->shifts as $shift)
                                                    <option value="{{ $shift->id }}"
                                                    @if(auth()->user()->preference->shift == $shift->id)
                                                        selected
                                                    @endif
                                                    >{{ Helper::getStartToEndAMPM($shift->start, $shift->end) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            </div>
                        <hr>
                        @endif
                        @if(isset($schedule))
                            @php
                                $schedules = json_decode($schedule);
                            @endphp
                            @for($i = 0; $i < sizeof($schedules); $i++)
                                @php
                                    $v = explode(',', $schedules[$i]);
                                @endphp
                                @if($v[0] == date('Y-m-d'))
                                    <div class="alert alert-info">
                                        <h1>{{ date('F d, Y', strtotime($v[0])) }} - {{ $v[1] }}</h1>
                                    </div>
                                @endif
                            @endfor
                        @endif
                    </div>
                </div>
            </div>
        </div>




        <div class="row" style="margin-top:24px;">
            <div class="col-md-12" id="schedule">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p style="float:left;"><strong>Schedule</strong></p>
                        <div id="monthContainer">
                            <button id ="monthLeft">&#171;</button>
                            <p id = "monthViewLabel">2018<br>September</p>
                            <button id ="monthRight">&#187;</button>
                        </div>
                    </div>
                    <div id="schedWindow" class="card-body" style="margin:0;padding:0;">
                        <div id="empSchedTableWrapper">
                            <table id="empSchedTable">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title text-white" id="exampleModalLongTitle">Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert" id="alert"></div>
            <form>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-user-secret"></i></div>
                        </div>
                        <input type="password" id="current_password" name="current_password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" required placeholder="Current Password">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="checkPassword" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/components/schedulerUI2.js') }}"></script>
    <script src="{{ asset('js/components/lib/lzjs.js') }}"></script>
    <script>
        var schedUI = new ScheduleManagerHTML2(this.document);
        schedUI.schedule = {!! $schedule !!};
        schedUI.Initialize(this.document);

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".modal").on("hidden.bs.modal", function(){
                location.reload();
            });
            
            var d = {!! auth()->user()->preference !!};
            var e = d.dayoff.toString();
            var f = [];
            var c = 1;
            var dayoff_counter = 0;
            for(var i = 0; i < e.length; i++){
                f[i] = e.charAt(i);
            }

            if(d != null){
                var count = 0;
                $('.btnDays').each(function(){
                    if(f[count] == '1'){
                        $(this).removeClass('btn-secondary').addClass('btn-primary');
                        $(this).removeAttr('name');
                        $(this).attr('name', 'active');
                        $(this).removeAttr('id');
                        $(this).attr('id', '1');
                        dayoff_counter++;
                    }
                    count++;
                });
            }
            
            if(dayoff_counter == c){
                $('.btnDays').each(function(){
                    if($(this).attr('id') == '0'){
                        $(this).attr('disabled', 'true');
                    }
                });
            }

            $('#selectedShift').on('change',function(){
                var val = $("#selectedShift option:selected").val();
                val = val==""?null:Number(val);
                var url = "{{ url('employee/dashboard/preference/update') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        // id: {!! auth()->user()->id !!},
                        column: 'shift',
                        value: val
                    },
                    success: function (result) {},
                });
            })

            $('.btnDays').on('click', function(){
                var x = '';
                var cc = 0;
                if($(this).attr('name') == 'inactive'){
                    $(this).removeClass('btn-secondary').addClass('btn-primary');
                    $(this).removeAttr('name');
                    $(this).attr('name', 'active');
                    $(this).removeAttr('id');
                    $(this).attr('id', '1');
                    cc++;
                } else {
                    $(this).removeClass('btn-primary').addClass('btn-secondary');
                    $(this).removeAttr('name');
                    $(this).attr('name', 'inactive');
                    $(this).removeAttr('id');
                    $(this).attr('id', '0');
                    cc--;
                }
                $('.btnDays').each(function(){
                    x += $(this).attr('id');
                });

                var url = "{{ url('employee/dashboard/preference/update') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        // id: {!! auth()->user()->id !!},
                        column: 'dayoff',
                        value: x.toString()
                    },
                    success: function (result) {},
                });

                if(cc == c){
                    $('.btnDays').each(function(){
                        if($(this).attr('id') == '0'){
                            $(this).attr('disabled', 'true');
                        }
                    }); 
                } else {
                    $('.btnDays').each(function(){
                        if($(this).attr('id') == '0'){
                            $(this).removeAttr('disabled');
                        }
                    }); 
                }
            });

            $('#checkPassword').on('click', function() {
                if($('#current_password').val() == null){
                    $('.modal-body .alert').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>
                            Please enter your current password.
                        </strong> 
                    </div>
                    `);
                } else {
                    var url = "{{ url('employee/dashboard/password-check/') }}"+"/"+$('#current_password').val();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        success: function (result) {
                            if(result['success']){
                                $('.modal-body').html(`
                                    <form action="{{ route('employee.change-password') }}" method="POST" class="form-signin">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-user-secret"></i></div>
                                                </div>
                                                <input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="New Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-user-secret"></i></div>
                                                </div>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-secondary" id="closeBtn" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                `);
                                $('.modal-footer').html('');
                            } else {
                                $('.modal-body .alert').html(`
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>
                                            Incorrect Password.
                                        </strong> 
                                    </div>
                                `); 
                            }
                        }
                    });
                    
                }
                
            });
        });
    </script>
@endsection