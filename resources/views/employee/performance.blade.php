@extends('layouts.employee')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/components/lib/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/lib/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
<section style="margin-top:30px">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">Evaluation</div>
                    <div class="card-body">
                        @if(count(auth()->user()->evaluation_files->where('active', 1)) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Filename</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach(auth()->user()->evaluation_files->where('active', 1)->sortByDesc('id') as $files)
                                <tr>
                                    <td>
                                        <a href="{{ asset('storage/pdf/') }}/{{ $files->filename }}" target="_blank">{{ $files->filename }} </a> 
                                    </td>
                                    <td>
                                        {{ $files->created_at->format('F d, Y') }}
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        @else
                            No files.
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('js/components/lib/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/components/lib/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.table').DataTable({

            });
        });
    </script>
@endsection