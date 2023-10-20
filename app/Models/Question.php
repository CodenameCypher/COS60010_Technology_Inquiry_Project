<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_topic',
        'question_content',
        'question_answer',
        'question_asked_time',
        'question_answered_time',
        'time_taken',
        'teacher_id',
        'student_id',
        'session_id'
    ];

    protected $casts = [
        'question_asked_time' => 'datetime',
        'question_answered_time' => 'datetime',
        'time_taken' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
