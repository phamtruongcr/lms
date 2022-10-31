<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\ChapterRequest;
use App\Models\Course\Chapter;
use App\Models\Course\ChapterTranslation;
use App\Models\Course\Course;
use App\Models\Course\CourseTranslation;
use App\Models\Course\LessonTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChapterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $chapters = Chapter::select([
            'chapters.id',
            'cht.name',
            'chapters.start_at',
            'chapters.finish_at',
            'slug',
            'ct.name AS course_name',
            'chapters.course_id',
            'created_at',
            'updated_at'
        ])
            ->leftJoin('chapter_translations AS cht', 'chapter_id', 'chapters.id')
            ->join('course_translations AS ct', 'chapters.course_id', 'ct.course_id')
            ->where('cht.lang', $this->lang)
            ->orderBy('chapters.id', 'desc')
            ->paginate();

        return view('admin.chapters.index', compact('chapters'));
    }

   /**
    * Display the specified resource.

    * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id){

        $chapter = Chapter::find($id);
        /** @phpstan-ignore-next-line  */
        $course = Course::find($chapter->course_id);
        $lessons = LessonTranslation::where('lang', $this->lang)
            ->pluck('name', 'lesson_id');

        return view('admin.chapters.detail', compact('chapter', 'course', 'lessons'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $chapter = new Chapter();
        $courses = CourseTranslation::where('lang', $this->lang)
            ->pluck('name', 'course_id');

        $lessons = LessonTranslation::where('lang', $this->lang)
            ->pluck('name', 'lesson_id');
        /** @phpstan-ignore-next-line  */
        if (is_null($courses)) {

            $lang = config('app.fallback_locale');
            $courses = CourseTranslation::where('lang', $this->lang)
                ->pluck('name', 'course_id');
        }

        return view('admin.chapters.create', compact('chapter', 'courses', 'lessons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChapterRequest $request

     * @return \Illuminate\Http\RedirectResponse 

     */
    public function store(ChapterRequest $request)
    {

        $chapter_item = $request->except('_token');
        /** @phpstan-ignore-next-line  */
        $msg = ChapterController::storeChapter($chapter_item);

        return redirect(route('chapter.index'))
            ->with('success', $msg);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ChapterRequest $request
     * @param  int $course_id

     * @return \Illuminate\Http\RedirectResponse 

     */
    public function storeChapterOfCourse(ChapterRequest $request, $course_id)
    {

        $chapter_item = $request->except('_token');
        $chapter_item['course_id'] = $course_id;

        /** @phpstan-ignore-next-line  */
        $msg = ChapterController::storeChapter($chapter_item);
        return redirect(route('course.detail', ['id' => $course_id]))
            ->with('success', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $chapter_item

     * @return String $msg 

     */
    private function storeChapter($chapter_item)
    {
        DB::beginTransaction();

        try {
            /** @phpstan-ignore-next-line  */
            $chapter_item['slug'] = Str::slug($chapter_item['name']);
            $chapter_item['lang'] = $this->lang;
            /** @phpstan-ignore-next-line  */
            if (ChapterTranslation::where('name', $chapter_item['name'])->first()) {
                return back()
                    /** @phpstan-ignore-next-line  */
                    ->with('failed', 'chapter ' . $chapter_item['name'] . ' already exists')
                    ->withInput();
            }

            $chapter = Chapter::create($chapter_item);

            $chapter_item['chapter_id'] = $chapter->id;

            ChapterTranslation::create($chapter_item);
            /** @phpstan-ignore-next-line  */
            if (isset($chapter_item['lesson_ids'])) {
                foreach ($chapter_item['lesson_ids'] as $lesson_id) {
                    $chapter->lessons()->attach($lesson_id);
                }
            }

            $msg = 'Create chapter is success';
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            throw new ModelNotFoundException();
        }
        return $msg;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $chapter = Chapter::find($id);

        if ($chapter) {
            $courses = CourseTranslation::where('lang', $this->lang)
                ->pluck('name', 'id');
            /** @phpstan-ignore-next-line  */
            if (is_null($courses)) {
                $lang = config('app.fallback_locale');
                $courses = CourseTranslation::where('lang', $lang)
                    ->pluck('name', 'id');
            }

            $lessons = LessonTranslation::where('lang', $this->lang)
                ->pluck('name', 'lesson_id');
            return view('admin.chapters.edit', compact('chapter', 'courses', 'lessons'));
        }

        return redirect(route('chapter.index'))
            ->with('failded', 'Chapter is not exitsting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChapterRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChapterRequest $request, $id)
    {
        $chapter = Chapter::find($id);

        if ($chapter) {
            $chapterTranslation = ChapterTranslation::where('chapter_id', $id)
                ->where('lang', $this->lang)
                ->first();

            if ($chapterTranslation) {
                /** @phpstan-ignore-next-line  */
                $chapterTranslation->name = $request->input('name');
                /** @phpstan-ignore-next-line  */
                $chapterTranslation->description = $request->input('description');
                $chapterTranslation->lang = $this->lang;
                $chapterTranslation->save();
            } else {
                return redirect(route('chapter.edit', $id))
                    ->with('error', 'No chapter in language ' . $this->lang);
            }

            $chapter->slug = Str::slug($chapterTranslation->name);
            /** @phpstan-ignore-next-line  */
            $chapter->course_id = $request->input('course_id');
            /** @phpstan-ignore-next-line  */
            $chapter->start_at = $request->input('start_at');
            /** @phpstan-ignore-next-line  */
            $chapter->finish_at = $request->input('finish_at');
            $chapter->save();

            if ($request->input('lesson_ids') != null) {
                /** @phpstan-ignore-next-line  */
                foreach ($request->input('lesson_ids') as $lesson_id) {
                    $chapter->lessons()->attach($lesson_id);
                }
            }

            $msg = 'Update chapter is success';
        }

        return redirect(route('chapter.index'))
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
        $chapter_id = $request->input('chapter_id', 0);
        $redirect = $request->input('redirect');

        if ($chapter_id) {
            $chapter = Chapter::find($chapter_id);
            /** @phpstan-ignore-next-line  */
            $course_id = $chapter->course_id;
            /** @phpstan-ignore-next-line  */
            $chapter->delete();

            DB::table('chapter_lessons')
                ->where('chapter_id', $chapter_id)
                ->delete();
            /** @phpstan-ignore-next-line  */
            $msg = "Delete chapter {$chapter_id} success!";

            if ($redirect == 'course') {
                return redirect(route('course.detail', ['id' => $course_id]))
                    ->with('success', $msg);
            }

            return redirect(route('chapter.index'))
                ->with('success', $msg);
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
        $data['chapters'] = DB::table('chapters')
            ->leftJoin('chapter_translations AS cht', 'chapter_id', 'chapters.id')
            ->join('course_translations AS ct', 'chapters.course_id', 'ct.course_id')
            ->where('cht.lang', $this->lang)
            ->where('ct.lang', $this->lang)
            ->whereRaw('match(cht.name) against(?)', array($request->content_search))
            ->get([
                'chapters.id',
                'cht.name',
                'chapters.start_at',
                'chapters.finish_at',
                'slug',
                'ct.name AS course_name',
                'chapters.course_id',
                'created_at',
                'updated_at'
            ]);
        return response()->json($data);
    }
}
