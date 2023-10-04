@extends('common.layout')

@section('title', 'Home | Bright Boost')

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
        @auth
            @if (auth()->user()->userType == 'Teacher')
                @include('Teacher.index')
            @elseif (auth()->user()->userType == 'Student')
                @include('Student.index')
            @else
                @include('Admin.index')
            @endif
        @else
        <h1>General Homepage!</h1>
        @endauth
    </div>
@endsection