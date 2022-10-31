<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\LessonRequest;
use App\Models\Course\Chapter;
use App\Models\Course\File;
use App\Models\Course\Lesson;
use App\Models\Course\LessonTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $lessons = Lesson::select([
            'lessons.id',
            'lt.name',
            'slug',
            'status',
            'st.name AS status_name',
            'lessons.created_at',
            'lessons.updated_at'
        ])
            ->leftJoin('lesson_translations AS lt', 'lesson_id', 'lessons.id')
            ->leftJoin('status_translations AS st', 'st.value', 'status')
            ->where('st.lang', $this->lang)
            ->where('lt.lang', $this->lang)
            ->orderBy('lessons.id', 'desc')
            ->paginate();

        return view('admin.lessons.index', compact('lessons'));
    }

    /**
     * Display the specified resource.
     *
     * @param   $slug
     * @return \Illuminate\View\View
     */
    /** @phpstan-ignore-next-line  */
    public function show($slug)
    {
        $lesson = Lesson::where('slug', $slug)->first();

        return view('admin.lessons.detail', compact('lesson'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $lesson = new Lesson();

        return view('admin.lessons.create', compact('lesson'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LessonRequest $request

     * @return \Illuminate\Http\RedirectResponse 

     */
    public function store(LessonRequest $request)
    {
        $lesson_item = $request->except('_token');

        DB::beginTransaction();

        try {
            $lesson_item['slug'] = Str::slug($lesson_item['name']);
            $lesson_item['lang'] = $this->lang;

            if (LessonTranslation::where('name', $lesson_item['name'])->first()) {
                return back()
                    ->with('failded', 'Lesson ' . $lesson_item['name'] . ' already exists')
                    ->withInput();
            }

            $lesson = Lesson::create($lesson_item);

            $lesson_item['lesson_id'] = $lesson->id;

            $lessonTranslation = LessonTranslation::create($lesson_item);

            /** @phpstan-ignore-next-line  */
            if ($request->hasFile('files') && $lesson) {
                /** @phpstan-ignore-next-line  */
                foreach ($request->file('files') as $file) {
                    $name = $lessonTranslation->name . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('files', $name);
                    File::create([
                        'lesson_id' => $lesson->id,
                        'path' => $path,
                        'type' => '2'
                    ]);
                }
            }

            $link_youtube = $request->input('link_youtube');

            if (!empty($link_youtube)) {
                File::create([
                    'lesson_id' => $lesson->id,
                    'path' => $link_youtube,
                    'type' => '1'
                ]);
            }

            $msg = 'Create lesson is success';
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            dd($t);
            /** @phpstan-ignore-next-line  */
            throw new ModelNotFoundException();
        }


        return redirect(route('lesson.index'))
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
        $lesson = Lesson::find($id);

        if ($lesson) {
            return view('admin.lessons.edit', compact('lesson'));
        }

        return redirect(route('lesson.index'))
            ->with('failded', 'Lesson is not exitsting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LessonRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LessonRequest $request, $id)
    {
        $lesson = Lesson::find($id);

        DB::beginTransaction();
        try {
            if ($lesson) {
                $lessonTranslation = LessonTranslation::where('lesson_id', $id)
                    ->where('lang', $this->lang)
                    ->first();

                if ($lessonTranslation) {
                    /** @phpstan-ignore-next-line  */
                    $lessonTranslation->name = $request->input('name');
                    /** @phpstan-ignore-next-line  */
                    $lessonTranslation->content = $request->input('content');
                    $lessonTranslation->lang = $this->lang;
                    $lessonTranslation->save();
                } else {
                    return redirect(route('lesson.edit', $id))
                        ->with('failded', 'No lesson in language ' . $this->lang);
                }

                $lesson->slug = Str::slug($lessonTranslation->name);
                $lesson->save();
            }

            if ($request->hasFile('files')) {
                /** @phpstan-ignore-next-line  */
                foreach ($request->file('files') as $file) {

                    /** @phpstan-ignore-next-line  */
                    $name = $lessonTranslation->name . '_' . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('files', $name);
                    File::create([
                        /** @phpstan-ignore-next-line  */
                        'lesson_id' => $lesson->id,
                        'path' => $path,
                        'type' => '2'
                    ]);
                }
            }

            $link_youtube = $request->input('link_youtube');

            if (!empty($link_youtube)) {
                $file = File::where('lesson_id', $id)
                    ->where('type', 1)->first();

                if ($file) {

                    /** @phpstan-ignore-next-line  */
                    $file->path = $link_youtube;
                    $file->save();
                } else {
                    File::create([
                        /** @phpstan-ignore-next-line  */
                        'lesson_id' => $lesson->id,
                        'path' => $link_youtube,
                        'type' => '1'
                    ]);
                }
            }

            $msg = 'Update lesson is success';
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            dd($t);
        }

        return redirect(route('lesson.index'))
            ->with('success', $msg);
    }

    /**
     * addLesson the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $chapter_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addLesson(Request $request, $chapter_id)
    {
        $chapter = Chapter::find($chapter_id);
        try {
            /** @phpstan-ignore-next-line  */
            foreach ($request->input('lesson_ids') as $lesson_id) {
                /** @phpstan-ignore-next-line  */
                $chapter->lessons()->attach($lesson_id);
            }

            $msg = 'Create chapter is success';
        } catch (\Throwable $t) {
            throw new ModelNotFoundException();
        }

        return redirect(route('chapter.detail', ['id' => $chapter_id]))
            ->with('success', $msg);
    }

    /**
     * destroyChapterLesson the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyChapterLesson(Request $request)
    {
        $lesson_id = $request->input('lesson_id', 0);
        $chapter_id = $request->input('chapter_id', 0);
        if ($lesson_id && $chapter_id) {
            $chapter_lesson = DB::table('chapter_lessons')
                ->where('lesson_id', $lesson_id)
                ->where('chapter_id', $chapter_id)
                ->delete();
            if ($request->input('redirect') == 'detail') {
                return redirect(route('chapter.detail', ['id' => $chapter_id]))
                    ->with('success', "Delete lesson success!");
            }
            return redirect(route('chapter.edit', ['id' => $chapter_id]))
                ->with('success', "Delete lesson success!");
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $lesson_id = $request->input('lesson_id', 0);
        if ($lesson_id) {
            /** @phpstan-ignore-next-line  */
            Lesson::find($lesson_id)->delete();

            return redirect(route('lesson.index'))
                /** @phpstan-ignore-next-line  */
                ->with('success', "Delete lesson {$lesson_id} success!");
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * destroyFile the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyFile(Request $request)
    {
        $file_id = $request->input('file_id', 0);
        if ($file_id) {
            $file = File::find($file_id);

            /** @phpstan-ignore-next-line  */
            $lesson_id = $file->lesson_id;
            /** @phpstan-ignore-next-line  */
            $file_name = $file->path;

            /** @phpstan-ignore-next-line  */
            $file->delete();
            Storage::delete($file_name);


            return redirect(route('lesson.edit', ['id' => $lesson_id]))
                /** @phpstan-ignore-next-line  */
                ->with('success', "Delete file {$file_id} success!");
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * search the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $data['lessons'] = DB::table('lessons')
            ->leftJoin('lesson_translations AS lt', 'lesson_id', 'lessons.id')
            ->leftJoin('status_translations AS ss', 'ss.value', 'status')
            ->where('ss.lang', $this->lang)
            ->where('lt.lang', $this->lang)
            ->whereRaw('match(lt.name) against(?)', array($request->content_search))
            ->get([
                'lessons.id',
                'lt.name',
                'slug',
                'status',
                'ss.name AS status_name',
                'lessons.created_at',
                'lessons.updated_at'
            ]);
        return response()->json($data);
    }
}
