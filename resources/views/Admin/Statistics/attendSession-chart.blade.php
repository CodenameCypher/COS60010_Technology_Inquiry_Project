@extends('common.layout')


@section('body')


<h3 style="text-align: center; color: #a63a50;">Statistics for Session ID: {{$sessionID}}</h3>


<div style="  width: 200px; border: 1px solid #ccc;  padding: 20px; text-align: center; display: inline-block; margin-top:4%; margin-left:18%;">
    <div style="  margin: 10px 0; font-weight: bold;">Total Students: {{$totalStudent}}</div>
</div>

<div style="  width: 200px; border: 1px solid #ccc;  padding: 20px; text-align: center; display: inline-block; margin-top:4%; margin-left:33%;">
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
        
        // plugins: {
        //     datalabels: {
        //         color: 'black', // Font color of the data labels
        //         formatter: (value, ctx) => {
        //             let sum = 0;
        //             let dataArr = ctx.chart.data.datasets[0].data;
        //             dataArr.map(data => {
        //                 sum += data;
        //             });
        //             let percentage = ((value / sum) * 100).toFixed(2) + "%";
        //             return percentage;
        //         }
        //     }
        // }

    };


    var attendanceChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
        
    });





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

@endsection



