<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Course\Lesson;
use App\Models\Group\Group;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends EloquentUser
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'phone',
        'birthday',
        'address',
        'first_name',
        'last_name',
        'last_login',
        'permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(){
        return $this->belongsToMany(
            Group::class,
            'group_students',
            'student_id',
            'class_id',
        );
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lessons(){
        return $this->belongsToMany(
            Lesson::class,
            'student_lessons',
            'student_id',
            'lesson_id',
        );
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


             /** @phpstan-ignore-next-line  */
    public function findForPassport($username) {
        return self::where('email', $username)->first(); // change column name whatever you use in credentials
    }
}
