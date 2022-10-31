<?php

namespace App\Models\Quizz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'test_id',
        'lang',
        'name',
        'description',
    ];
}
