<?php

namespace App\Models\Quizz;

use App\Models\Course\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function PHPUnit\Framework\isNull;

class Answer extends Model
{
    use HasFactory;
      /**
     * @var array<int,string>
     */
    protected $fillable=[
        'lesson_id',
        'status',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answerTranslations()
    {
        return $this->hasMany(AnswerTranslation::class);
    }

    /**
     *
     * @param string|null $lang
     * @return AnswerTranslation|null
     */
    public function translate($lang = null)
    {
        if ($lang == null) {
            $lang = app()->getLocale();
        }
        $t = $this->answerTranslations()->where('lang', $lang)->first();

        if (is_null($t)) {
            $lang = config('app.fallback_locale');
            $t = $this->answerTranslations()->where('lang', $lang)->first();
        }
        return $t;
    }
}
