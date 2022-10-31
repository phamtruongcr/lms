<?php

namespace App\Models\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'class_manager_id',
    ];
}
