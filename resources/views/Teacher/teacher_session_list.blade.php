@extends('common.layout')

@section('title', 'Available Sessions | Bright Boost')

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
                  
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                      $rowNumber = 1; 
                    @endphp
                  @foreach (\App\Models\Session::all() as $session)
              
                 
            <tr>
            @if(is_null($session->teacher_id))
                <th scope="row">{{ $rowNumber }}</th>
                <td>{{$session->id}}</td>
                <td>{{$session->session_topic}}</td>
                <td>{{$session->session_starting_time}}</td>
                <td>{{$session->session_ending_time}}</td>
         
                <td>
                    <form action="{{route('teacherSessionEnroll',$session->id)}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success btn-sm">Enroll</button>
                    </form>
                    
                </td>
                @php
                      $rowNumber++; 
                @endphp 
            </tr>
            @endif
     
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
    
</div>

@endsection
