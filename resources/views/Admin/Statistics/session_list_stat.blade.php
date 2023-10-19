@extends('common.layout')

@section('title', 'Statistics| Bright Boost')

@section('body')
<div class="mt-5">
    @if ($errors->any())
        <div class="col-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success ">
            {{session('success')}}
        </div>
    @endif
</div>

<div class="container">
    <div class="container bg-white">
        <div class="col-md-12 text-center">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Topic</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Teacher</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (\App\Models\Session::all() as $session)
                    <tr>
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$session->id}}</td>
                        <td>{{$session->session_topic}}</td>
                        <td>{{$session->session_starting_time}}</td>
                        <td>{{$session->session_ending_time}}</td>
                        @if (is_null($session->teacher_id))
                        <td>TBA</td>
                        @else 
                        <td>{{$session->teacher->user->name}}</td>
                        @endif
                        <td>
                            <form>
                                @csrf
                                <a class="btn btn-outline-success btn-sm" href='{{route('adminCharts',$session->id)}}'>View Statistics</a>

                            </form>
                            
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
    
</div>

@endsection