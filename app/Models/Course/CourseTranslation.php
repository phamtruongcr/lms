<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'course_id',
        'lang', 
        'name',
        'description',
    ];
}
