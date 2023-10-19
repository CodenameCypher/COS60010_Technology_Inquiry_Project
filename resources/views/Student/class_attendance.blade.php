@extends('common.layout')

@section('title', 'Class Attendence | Bright Boost')

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
                    <th scope="col">Topic</th>
                    <th scope="col">Content</th>
                    <th scope="col">Asked By</th>
                    <th scope="col">Answered By</th>
                    <th scope="col">Asked In</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (\App\Models\Question::all() as $question)
                    <tr>
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$question->question_topic}}</td>
                        <td>{{$question->question_content}}</td>
                        <td>{{$question->student->user->name}}</td>
                        <td>{{$question->teacher->user->name ?? "-"}}</td>
                        <td>Session ID {{$question->session->id}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <a href="{{ route('ask.question.form', ['id' => $sessionId]) }}" class="btn btn-primary">Ask Question</a>

        </div>
    </div>
    
</div>

@endsection