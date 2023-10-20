@extends('common.layout')

@section('title', 'See Question | Bright Boost')

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
                    <div class="card-header">See Answer</div>
                    <div class="card-body">
                        <p><b>Question Topic:</b> {{$question->question_topic}}</p>
                        <p><b>Question Content:</b> {{$question->question_content}}</p>
                        <p><b>Question Answer:</b> {{$question->question_answer}}</p>
                        <p><b>Question Answer:</b> {{$question->question_answered_time}}</p>
                        <p><b>Question Answered By:</b> {{$question->teacher == null ? "TBA" : $question->teacher->user->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection