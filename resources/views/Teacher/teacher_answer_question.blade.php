@extends('common.layout')

@section('title', 'Answer Question | Bright Boost')

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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Answer Question</div>

                    <div class="card-body">
                        <p><b>Question Topic:</b> {{$question->question_topic}}</p>
                        <p><b>Question Content:</b> {{$question->question_content}}</p>
                        <form method="POST" action="{{route('teacherSessionAnswerQuestion.post',['sessionID'=>$session->id, 'questionID'=>$question->id])}}">
                            @csrf
                            <div class="form-group">
                                <label for="question">Answer</label>
                                <textarea id="question" name="questionAnswer" class="form-control" style="margin-bottom:10px" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection