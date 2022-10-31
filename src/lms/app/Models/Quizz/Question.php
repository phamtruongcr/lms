<?php

namespace App\Models\Quizz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course\Lesson;

class Question extends Model
{
    use HasFactory;
    protected $fillable=[
        'slug',
        'lesson_id',
        'point',
        'type',
    ];
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function answers()
    {
        return $this->belongsToMany(
            Answer::class,
            'question_id',
            'answer_id',

        );
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionTranslations()
    {
        return $this->hasMany(QuestionTranslation::class);
    }

    /**
     *
     * @param string|null $lang
     * @return QuestionTranslation|null
     */
    public function translate($lang = null)
    {
        if (null == $lang) {
            $lang = app()->getLocale();
        }
        $t = $this->questionTranslations()->where('lang', $lang)->first();

        if (is_null($t)) {
            $lang = config('app.fallback_locale');
            $t = $this->questionTranslations()->where('lang', $lang)->first();
        }
        return $t;
    }
}
