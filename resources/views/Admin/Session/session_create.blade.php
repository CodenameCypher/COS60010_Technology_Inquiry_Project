@extends('common.layout')

@section('title', 'Sessions | Bright Boost')

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

<div class="container bg-white">
    <div class="col-md-12">
        <h1 class="text-center">
            Create a Session
        </h1>
        <form method="POST" action="{{route('adminSessionCreate.post')}}">
            @csrf
            <div class="form-group my-3">
              <label for="SessionTopic">Session Topic</label>
              <input type="text" class="form-control" id="SessionTopic" placeholder="Session Topic" name="SessionTopic">
            </div>
            <div class="form-group my-3">
              <label for="SessionStartingTime">Starting Date & Time</label>
              <input type="datetime-local" class="form-control" id="SessionStartingTime" placeholder="Session Starting Time" name="SessionStartingTime">
            </div>
            <div class="form-group my-3">
              <label for="SessionEndingTime">Ending Date & Time</label>
              <input type="datetime-local" class="form-control" id="SessionEndingTime" placeholder="Session Ending Time" name="SessionEndingTime">
            </div>
            <div class="form-group my-3">
                <label for="Teacher">Teacher</label>
                <select id="Teacher" class="form-control" name="Teacher">
                    <option value="no teacher">---</option>
                  @foreach (\App\Models\Teacher::all() as $teacher)
                      <option value="{{$teacher->id}}">{{$teacher->user->name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection