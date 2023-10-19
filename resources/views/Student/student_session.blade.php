@extends('common.layout')

@section('title', 'Session Dashboard | Bright Boost')

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
            <h1>Session #{{$session->id}} - {{$session->session_topic}}</h1>
            <h5 style="margin-bottom: 30px">Conducted By - {{$session->teacher->user->name}}</h5>
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Topic</th>
                    <th scope="col">Content</th>
                    <th scope="col">Asked</th>
                    <th scope="col">Asked By</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($session->questions as $question)
                    <tr>
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$question->question_topic}}</td>
                        <td>{{$question->question_content}}</td>
                        <td>{{$question->question_asked_time}}</td>
                        <td>{{$question->student->user->name}}</td>
                        <td>
                            @if ($question->question_answer != "" and $question->question_answer != null)
                            <a class="btn btn-outline-success btn-sm" href="#">See Answer</a>
                            @else
                            <button class="btn btn-outline btn-sm" disabled>See Answer</button>
                            @endif
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <a class="center" href="{{route('studentSessionPostQuestion',$session->id)}}">
                <button type="button" class="btn btn-dark">Post Question</button>
            </a>
        </div>
    </div>
    
</div>

@endsection