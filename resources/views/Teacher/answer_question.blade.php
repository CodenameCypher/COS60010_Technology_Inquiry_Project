@extends('common.layout')

@section('title', 'Answer | Bright Boost')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Answer :</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('submit.answer', $sessionId)}}">
                            @csrf

                            <div class="form-group">
                                
                                <label for="answer">Answer</label>
                                <textarea id="answer" name="answer" class="form-control" required></textarea>
                                
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Answer</button>
                        </form>

                        <div class="mt-3">
                            <a href="{{ route('teachAttendance', ['id' => $sessionId]) }}" class="btn btn-secondary">View Answer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection