@extends('common.layout')

@section('title', 'Enrolled Sessions | Bright Boost')

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
                    <!-- Displaying all the enrooled session list to student user with unenroll option.-->
                  @foreach ($enrolled_sessions as $session)
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
                            @if (now() >= \Carbon\Carbon::parse($session->session_starting_time) && now() <= \Carbon\Carbon::parse($session->session_ending_time))
                                <a class="btn btn-outline-success btn-sm" href="{{route('studentSessionDashboard', $session->id)}}">Join</a>
                            @else
                                <button type="submit" class="btn btn-outline btn-sm" disabled>Join</button>
                            @endif
                            
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
    
</div>

@endsection