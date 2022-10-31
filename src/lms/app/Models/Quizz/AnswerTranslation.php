<?php

namespace App\Models\Quizz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'answer_id',
        'lang', 
        'content',
    ];
}
