<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CourseRequest;
use App\Models\Course\Course;
use App\Models\Course\CourseTranslation;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Course $course
     */
    public function index()
    {
        $courses = Course::select([
            'courses.id',
            'slug', 
            'start_at', 
            'finish_at', 
            'courses.created_at', 
            'courses.updated_at'
        ])
        ->with(
            'courseTranslations', 
            'chapters', 
            'chapters.chapterTranslations', 
            'chapters.lessons',
            'chapters.lessons.lessonTranslations',
        ) 
        ->orderBy('courses.id', 'desc')
        ->paginate();
        
        /** @phpstan-ignore-next-line  */
        return $courses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CourseRequest  $request
     * @return Course $course
     */
    public function store(CourseRequest $request)
    {
        $course_item = $request->except('_token');

        var_dump($course_item);
        
        DB::beginTransaction();
        
        try{
            $course_item['slug'] = Str::slug($course_item['name']);
            $course_item['lang'] = $this->lang;
            
            if(CourseTranslation::where('name', $course_item['name'])->first()){
                /** @phpstan-ignore-next-line  */
                return back()
                ->with('error', 'Course ' .$course_item['name']. ' already exists')
                ->withInput();
            }
    
            $course = Course::create($course_item);
    
            $course_item['course_id'] = $course->id;
    
            CourseTranslation::create($course_item);

            $photo = $request->file('photo');

            if ($photo){
                
                /** @phpstan-ignore-next-line  */
                $path = Storage::putFile('files', $photo);
                $image = Image::create(['name'=>$path]);
                $course->image_id = $image->id;
                $course->save();
            }

            DB::commit();
            
        }catch(Throwable $t){
            DB::rollBack();
            throw new ModelNotFoundException();
        }
        
        return $course;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
