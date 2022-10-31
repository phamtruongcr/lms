<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CourseRequest;
use App\Models\Course\Chapter;
use App\Models\Course\Course;
use App\Models\Course\CourseTranslation;
use App\Models\Course\Lesson;
use App\Models\Course\LessonTranslation;
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $courses = Course::select([
            'courses.id',
            'ct.name',
            'images.name as image',
            'slug',
            'start_at',
            'finish_at',
            'courses.created_at',
            'courses.updated_at'
        ])
            ->leftJoin('course_translations AS ct', 'course_id', 'courses.id')
            ->leftJoin('images', 'images.id', 'courses.image_id')
            ->where('lang', $this->lang)
            ->paginate();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $course = Course::find($id);
        $chapters = Chapter::select([
            'chapters.id',
            'chapters.slug',
            'ct.name',
            'start_at',
            'finish_at',
            'created_at',
            'updated_at'
        ])
            ->leftJoin('chapter_translations AS ct', 'chapter_id', 'chapters.id')
            ->where('lang', $this->lang)
            /** @phpstan-ignore-next-line  */
            ->where('chapters.course_id', $course->id)
            ->paginate();

        $lessons = LessonTranslation::where('lang', $this->lang)
            ->pluck('name', 'lesson_id');

        return view('admin.courses.detail', compact('course', 'chapters', 'lessons'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $course = new Course();
        return view('admin.courses.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CourseRequest $request

     * @return \Illuminate\Http\RedirectResponse 

     */
    public function store(CourseRequest $request)
    {
        $course_item = $request->except('_token');

        DB::beginTransaction();

        try {
            $course_item['slug'] = Str::slug($course_item['name']);
            $course_item['lang'] = $this->lang;

            if (CourseTranslation::where('name', $course_item['name'])->first()) {
                return back()
                    ->with('error', 'Course ' . $course_item['name'] . ' already exists')
                    ->withInput();
            }

            $course = Course::create($course_item);

            $course_item['course_id'] = $course->id;

            CourseTranslation::create($course_item);

            $photo = $request->file('photo');

            if ($photo) {
                /** @phpstan-ignore-next-line  */
                $path = Storage::putFile('files', $photo);
                $image = Image::create(['name' => $path]);
                $course->image_id = $image->id;
                $course->save();
            }

            $msg = 'Create course is success';
            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();
            throw new ModelNotFoundException();
        }

        return redirect(route('course.detail', ['id' => $course->id]))
            ->with('success', $msg);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $course = Course::find($id);

        if ($course) {
            return view('admin.courses.edit', compact('course'));
        }

        return redirect(route('course.index'))
            ->with('failded', 'course is not exitsting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CourseRequest $request, $id)
    {
        $course = Course::find($id);

        if ($course) {
            $courseTranslation = CourseTranslation::where('course_id', $id)
                ->where('lang', $this->lang)
                ->first();

            if ($courseTranslation) {
                /** @phpstan-ignore-next-line  */
                $courseTranslation->name = $request->input('name');
                /** @phpstan-ignore-next-line  */
                $courseTranslation->description = $request->input('description');
                $courseTranslation->lang = $this->lang;
                $courseTranslation->save();
            } else {
                return redirect(route('course.edit', $id))
                    ->with('error', 'No course in language ' . $this->lang);
            }

            $course->slug = Str::slug($courseTranslation->name);
            /** @phpstan-ignore-next-line  */
            $course->start_at = $request->input('start_at');
            /** @phpstan-ignore-next-line  */
            $course->finish_at = $request->input('finish_at');
            $course->save();

            $photo = $request->file('photo');
            $image = Image::find($course->image_id);

            if ($photo && $image) {
                Storage::delete($image->name);
                /** @phpstan-ignore-next-line  */
                $name = $courseTranslation->name . '_' . time() . rand(1, 100) . '.' . $photo->getClientOriginalExtension();
                /** @phpstan-ignore-next-line  */
                $path = $photo->storeAs('files', $name);
                /** @phpstan-ignore-next-line  */
                $image->name = $path;
                $image->save();
            } elseif ($photo) {
                /** @phpstan-ignore-next-line  */
                $name = $courseTranslation->name . '_' . time() . rand(1, 100) . '.' . $photo->getClientOriginalExtension();
                /** @phpstan-ignore-next-line  */
                $path = $photo->storeAs('files', $name);
                $image = Image::create(['name' => $path]);
                $course->image_id = $image->id;
                $course->save();
            }
            /** @phpstan-ignore-next-line  */
            $course->image_id = $image->id;
            $course->save();

            $msg = 'Update course is success';
        }

        return redirect(route('course.index'))
            /** @phpstan-ignore-next-line  */
            ->with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $course_id = $request->input('course_id', 0);
        if ($course_id) {
            /** @phpstan-ignore-next-line  */
            Course::destroy($course_id);
            CourseTranslation::where('course_id', $course_id)
                ->delete();

            return redirect(route('course.index'))
                /** @phpstan-ignore-next-line  */
                ->with('success', "Delete course {$course_id} success!");
        } else {
            throw new ModelNotFoundException();
        }
    }
    /**
     * search the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $data['courses'] = DB::table('courses')
            ->leftJoin('course_translations AS ct', 'course_id', 'courses.id')
            ->leftJoin('images', 'images.id', 'courses.image_id')
            ->where('lang', $this->lang)
            ->whereRaw('match(ct.name) against(?)', array($request->content_search))
            ->get([
                'courses.id',
                'ct.name',
                'images.name as image',
                'slug',
                'start_at',
                'finish_at',
                'courses.created_at',
                'courses.updated_at'
            ]);
        return response()->json($data);
    }
}

