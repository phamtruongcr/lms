<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable=[
        'slug',
        'course_id',
        'start_at',
        'finish_at',
    ];

 /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    /**
     * [description]
     * 
     */
/**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lessons()
    {
        return $this->belongsToMany(
            Lesson::class,
            'chapter_lessons',
            'chapter_id',
            'lesson_id',
        );
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapterTranslations()
    {
        return $this->hasMany(ChapterTranslation::class);
    }

    /**
     *
     * @param string|null $lang
     * @return ChapterTranslation|null
     */
    public function translate($lang = null)
    {
        if (null == $lang) {
            $lang = app()->getLocale();
        }
        $t = $this->chapterTranslations()->where('lang', $lang)->first();

        if (is_null($t)) {
            $lang = config('app.fallback_locale');
            $t = $this->chapterTranslations()->where('lang', $lang)->first();
        }
        return $t;
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($chapter) { // before delete() method call this
            $chapter->chapterTranslations()->delete();
             // do the rest of the cleanup...
        });
    }
}
