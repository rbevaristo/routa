<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <style>
        td {
            font-size: 12px;
            padding: 1px;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="text-center">
            <h1>{{ $data['company']['name'] }}</h1>
            <h6>{{ $data['address'] }} | {{ $data['company']['email'] }} | {{ $data['profile']['contact'] }}</h6>
        </div>
        <div class="text-center">
            <h3>Schedule <span class="float-right"><small>Date: {{ date('F d, Y') }}</small></span></h3>
        </div>
        <div class="text-center">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <td></td>
                        @php
                            $start = $data['start'];
                            $end = $data['end'];
                        @endphp
                        @while(strtotime($start) != strtotime($end))
                            <td>
                                {{ date('M d', strtotime($start)) }} <br>
                                {{ date('D', strtotime($start)) }}
                            </td>
                            @php
                                $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
                            @endphp
                        @endwhile
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['shifts'] as $shift)
                    <tr>
                        <td>{{ Helper::getStartToEndAMPM($shift->start, $shift->end) }}</td>
                        @php
                            $start = $data['start'];
                            $end = $data['end'];
                        @endphp
                        @while(strtotime($start) != strtotime($end))
                            <td>
                                @foreach(auth()->user()->employee_schedules as $schedule)
                                    @php
                                        $ns = json_decode($schedule->schedule);
                                    @endphp
                                    @for($i = 0; $i < sizeof($ns); $i++)
                                        @php
                                            $d = explode(',', $ns[$i]);
                                            $h = explode('-', $d[1]);
                                            $x = Helper::getStartToEndAMPM($h[0], $h[1]);
                                            $u = Helper::getStartToEndAMPM($shift->start, $shift->end);
                                        @endphp
                                        @if(strtotime($d[0]) == strtotime($start) && $x == $u)
                                            @php
                                                $employee = auth()->user()->employees->where('id', $schedule->emp_id)->first();
                                            @endphp
                                            {{ $employee->firstname }} {{ $employee->lastname }} <small>({{ $employee->position->name }})</small><br>
                                        @endif
                                    @endfor
                                @endforeach
                            </td>
                            @php
                                $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
                            @endphp
                        @endwhile
                    </tr>
                    @endforeach
                </tbody>
            </table>
           
        </div>
    </div>
</body>
</html>