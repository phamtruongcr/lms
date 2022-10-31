<?php

namespace App\Models\Group;

use App\Models\Course\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'class_manager_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'group_courses',
            'class_id',
            'course_id',
        );
    }
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'group_students',
            'class_id',
            'student_id',
        );
    }
}
