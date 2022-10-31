<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'chapter_id',
        'lang', 
        'name',
        'description',
    ];
}
