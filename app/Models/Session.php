<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_topic',
        'session_starting_time',
        'session_ending_time',
        'teacher_id'
    ];

    protected $casts = [
        'session_starting_time' => 'datetime',
        'session_ending_time' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('student_id')->withTimestamps(); //adding so that attach() method can be used as many-many relationship
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
