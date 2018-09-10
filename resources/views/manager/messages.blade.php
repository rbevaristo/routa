@extends('layouts.manager')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/components/lib/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/components/lib/dataTables.bootstrap4.min.css') }}">
    <style>
        @media (max-width: 576px){
            #users-message{
                font-size: 10px;
            }
        }
    </style>
@endsection
@section('content')
<section id="users-message" style="margin-top:30px">
    <div class="container-fluid">
        <div class="row" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Inbox
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered text-center">
                                @if(\App\UserRequest::all()->sortByDesc('id')->where('user_id', auth()->user()->id)->count() > 0)
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Date Requested</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->user_requests as $req)
                                        <tr>
                                           <td> 
                                               <a href="{{ route('user.message.view', ['id' => $req->id]) }}">
                                                   {{ $req->title }}
                                               </a>
                                           
                                           </td>
                                           <td>{{ Helper::limit_message($req->message, 5)}}</td>
                                           <td>
                                               {{ date('F d, Y', strtotime($req->from)) }} - 
                                               {{ date('F d, Y', strtotime($req->upto)) }}
                                           </td>
                                           @if($req->approved && strtotime($req->from) > strtotime(date('Y-m-d')))
                                               <td>Approved</td>
                                           @else
                                               @if(strtotime($req->from) < strtotime(date('Y-m-d')))
                                               <td>Expired</td>
                                               @else
                                               <td>Pending</td>
                                               @endif
                                           @endif
                                       </tr>
                                   @endforeach
                                </tbody>
                                @else
                                    No message
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom_scripts')
<script src="{{ asset('js/components/lib/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/components/lib/dataTables.boostrap4.min.js') }}"></script>
<script>
        $(document).ready(function(){
            $('.table').DataTable({
               
            });
        });
</script>
@endsection