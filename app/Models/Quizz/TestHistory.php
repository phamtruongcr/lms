<?php

namespace App\Models\Quizz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestHistory extends Model
{
    use HasFactory;
    protected $fillable=[
        'student_test_id',
        'score',
        'time',
        'index',
        'key'
    ];
}
