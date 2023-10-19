@extends('common.layout')

@section('title', 'Ask-Question | Bright Boost')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ask a Question</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('submit.question', $sessionId)}}">
                            @csrf

                            <div class="form-group">
                                <label for="questionTopic">Your Question Topic</label>
                                <textarea id="questionTopic" name="questionTopic" class="form-control" required></textarea>
                                <label for="question">Your Question</label>
                                <textarea id="question" name="question" class="form-control" required></textarea>
                            
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Question</button>
                        </form>

                        <div class="mt-3">
                            <a href="{{ route('studentClassAttendance', ['id' => $sessionId]) }}" class="btn btn-secondary">Question List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
