<?php

namespace App\Models\Course;

use App\Models\Quizz\Answer;
use App\Models\Quizz\Question;
use App\Models\Quizz\Test;
use App\Models\User;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable=[
        'slug',
        'status',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'student_lessons',
            'student_id',
            'lesson_id',
        );
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters(){
        return $this->hasMany(Chapter::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonTranslations()
    {
        return $this->hasMany(LessonTranslation::class);
    }

    /**
     *
     * @param string|null $lang
     * @return LessonTranslation|null
     */
    public function translate($lang = null)
    {
        if (null == $lang) {
            $lang = app()->getLocale();
        }
        $t = $this->lessonTranslations()->where('lang', $lang)->first();

        if (is_null($t)) {
            $lang = config('app.fallback_locale');
            $t = $this->lessonTranslations()->where('lang', $lang)->first();
        }
        return $t;
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($lesson) { // before delete() method call this
            $lesson->lessonTranslations()->delete();
             // do the rest of the cleanup...
        });
    }

}
