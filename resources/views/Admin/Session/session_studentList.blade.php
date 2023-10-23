@extends('common.layout')

@section('title', 'Users | Bright Boost')

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
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
              
                  @foreach ($session->students as $user)
                    <tr>
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$user->firstName}} {{$user->lastName}}</td>
                        <td>
                        <a class="btn btn-outline-success btn-sm" href='{{route('studentUnenroll',['sessionID'=>$session->id, 'studentID'=>$user->id])}}'>Unenroll</a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
    
</div>

@endsection