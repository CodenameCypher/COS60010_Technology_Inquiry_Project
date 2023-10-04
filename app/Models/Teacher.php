<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'contactNumber',
        'subjectSpeciality',
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
