<?php

namespace App\Models\Course;

use App\Models\Image;
use App\Models\Group\Group;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable=[
        'slug',
        'image_id',
        'start_at',
        'finish_at',
    ];
    
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image(){
        return $this->belongsTo(Image::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseTranslations()
    {
        return $this->hasMany(CourseTranslation::class);
    }

    /**
     *
     * @param string|null $lang
     * @return CourseTranslation|null
     */
    public function translate($lang = null)
    {
        if (null == $lang) {
            $lang = app()->getLocale();
        }
        return $this->courseTranslations()->where('lang', $lang)->first();
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($course) { // before delete() method call this
            $course->courseTranslations()->delete();
             // do the rest of the cleanup...
        });
    }
}