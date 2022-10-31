<?php

namespace App\Models\Quizz;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course\Lesson;
use App\Models\User;

class Test extends Model
{
    use HasFactory;
    protected $fillable=[
        'lesson_id',
        'slug',
        'total_point',
        'total_time',
        'limit',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'test_questions',
            'test_id',
            'question_id'
        );
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'student_tests',
            'test_id',
            'student_id',
        );
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testTranslations()
    {
        return $this->hasMany(TestTranslation::class);
    }

    /**
     *
     * @param string $lang
     * @return TestTranslation|null
     */
    public function translate($lang = null)
    {
        if (null == $lang) {
            $lang = app()->getLocale();
        }
        $t = $this->testTranslations()->where('lang', $lang)->first();

        if (is_null($t)) {
            $lang = config('app.fallback_locale');
            $t = $this->testTranslations()->where('lang', $lang)->first();
        }
        return $t;
    }
    
}
