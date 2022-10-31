<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'lesson_id',
        'lang',
        'name',
        'content',
    ];
}
