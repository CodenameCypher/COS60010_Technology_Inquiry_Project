@extends('common.layout')

@section('title', 'Statistics | Bright Boost')

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

<h3 style="text-align: center; color: #a63a50;">Statistics for Session ID: {{$sessionID}}</h3>


<div style="  width: 200px; border: 1px solid #ccc;  padding: 20px; text-align: center; display: inline-block; margin-top:4%; margin-left:19%; margin-right: 1%;">
    <div style="  margin: 10px 0; font-weight: bold;">Total Students: {{$totalStudent}}</div>
</div>

<div style="  width: 350px; border: 1px solid #ccc;  padding: 20px; text-align: center; display: inline-block; margin-top:4%; margin-left:4%;">
    <div style="  margin: 10px 0; font-weight: bold;">Average Time to Answer: {{$averageAnsTime}} Seconds</div>
</div>

<div style="  width: 200px; border: 1px solid #ccc;  padding: 20px; text-align: center; display: inline-block; margin-top:4%; margin-left:4.5%;">
    <div style="  margin: 10px 0; font-weight: bold;">Total Questions: {{$totalQuestions}}</div>
</div>

<div style=" display:block;" >
    <!-- //Empty block. -->
</div>

<div style="height: 400px; width: 400px;  display:inline-block; margin-top:2%; margin-left:12%;">
    <canvas id="attendanceChart"></canvas>
</div>

<div style="height: 400px; width: 400px; display:inline-block;  margin-top:2%; margin-left:20%;">
    <canvas id="answerChart"></canvas>
</div>

<script>

     // Attended & Not Attended pie chart.
    var ctx = document.getElementById('attendanceChart').getContext('2d');
    var data = {
        labels: ['Attended', 'Not Attended'],
        datasets: [{
            data: [{{ $attended }}, {{ $notAttended }}],
            backgroundColor: ['#36A2EB', '#FF6384']
        }]
    };

    var options = {
        responsive: true

    };

    var attendanceChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
        
    });


    // Answered & Not Answered doughnut chart.
    var answersCtx = document.getElementById('answerChart').getContext('2d');

    var dataAns = {
        labels: ['Answered', 'Not Answered'],
        datasets: [{
            data: [{{ $answered }}, {{ $notAnswered }}],
            backgroundColor: ['#008000', '#FFC300'] 
        }]
    };

    var doughnutChart = new Chart(answersCtx, {
        type: 'doughnut',
        data: dataAns,
        options: options
    });


</script>




<!-- Question Table Display: -->

<div style=" display:block; margin-bottom:3%" >
    <!-- //Empty block. -->
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
                    <th scope="col">Time Taken</th>
                  </tr>
                </thead>
                <tbody>
            

                  @foreach (\App\Models\Question::whereNotNull('teacher_id')->where('session_id', $sessionID)->get() as $question)
                    <tr>
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$question->question_topic}}</td>
                        <td>{{$question->question_content}}</td>
                        <td>{{$question->time_taken}}</td>

                    </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
    
</div>

@endsection



