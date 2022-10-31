<?php

namespace App\Models\Quizz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'question_id',
        'lang', 
        'content',
    ];
}
