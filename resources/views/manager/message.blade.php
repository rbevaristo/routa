@extends('layouts.manager')
@section('styles')
    <style>
        @media (max-width: 576px){
            #users-message{
                font-size: 12px;
            }
        }
    </style>
@endsection
@section('content')
<section style="margin-top:30px">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ $message->title }}
                        <span class="float-right">
                            <a href="{{ route('manager.messages')}}" class="text-white"> View all</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <p>From:  <strong>{{ App\Employee::find($message->emp_id)->firstname }} {{ App\Employee::find($message->emp_id)->lastname }} </strong></p>
                        <p>Date Requested:  <strong>{{ date('F d, Y', strtotime($message->created_at)) }}
                            </strong></p>
                        <p>Request Date:  <strong>{{ date('F d, Y', strtotime($message->from)) }} - {{ date('F d, Y', strtotime($message->upto)) }}
                                </strong></p>
                        Message: <p style="text-indent:60px;"> <strong>{{ $message->message }}</strong></p>
                    </div>
                    <div class="card-footer text-right">
                        @if(!$message->approved && strtotime($message->from) > strtotime(date('Y-m-d')))
                            <form action="{{ route('user.request.approve') }}" method="POST">
                                @csrf
                                <input type="hidden" name="request_id" value="{{ $message->id }}">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Approve</button>
                                </div>
                            </form>
                        @else
                        <small>
                            @if($message->approved)
                                Approved {{ date('F d, Y', strtotime($message->updated_at)) }}
                            @elseif(strtotime($message->from) < strtotime(date('Y-m-d')))
                                Expired
                            @else
                                Pending
                            @endif
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection