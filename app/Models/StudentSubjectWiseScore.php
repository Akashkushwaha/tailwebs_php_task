<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubjectWiseScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'subject',
        'marks'
    ];
}
