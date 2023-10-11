<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'contactNumber',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sessions()
    {
        return $this->belongsToMany(Session::class)->withPivot('session_id')->withTimestamps();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
