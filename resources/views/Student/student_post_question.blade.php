@extends('common.layout')

@section('title', 'Post Question | Bright Boost')

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
                    <div class="card-header">Post A Question</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('studentSessionPostQuestion.post',$session->id)}}">
                            @csrf
                            <div class="form-group">
                                <label for="questionTopic">Topic</label>
                                <input id="questionTopic" name="questionTopic" class="form-control" required></textarea>
                                <label for="question">Question Content</label>
                                <textarea id="question" name="questionContent" class="form-control" style="margin-bottom:10px" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection