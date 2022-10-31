<?php

namespace App\Http\Controllers\Admin\Quizz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Quizz\TestRequest;
use App\Models\Course\LessonTranslation;
use App\Models\Quizz\Test;
use App\Models\Quizz\TestTranslation;
use App\Models\StatusTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    protected function index()
    {
        $tests = Test::select([
            'tests.id',
            'tt.name',
            'slug',
            'lt.name AS lesson_name',
            'tests.lesson_id',
            'tests.status',
            'ss.name AS status_name',
            'total_point',
            'total_time',
            'limit',
            'tt.description',
            'tests.created_at',
            'tests.updated_at',
        ])
            ->leftJoin('test_translations AS tt', 'test_id', 'tests.id')
            ->join('lesson_translations AS lt', 'tests.lesson_id', 'lt.lesson_id')
            ->leftJoin('status_translations AS ss', 'ss.value', 'status')
            ->where('ss.lang', $this->lang)
            ->where('tt.lang', $this->lang)
            ->where('lt.lang', $this->lang)
            ->orderBy('tests.id', 'desc')
            ->paginate();
        $status = StatusTranslation::select([
            'value',
            'name',
        ])
            ->where('lang', $this->lang)
            ->paginate();
        return view('admin.tests.index', compact('tests', 'status'));
    }

    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $test = new Test();
        $lessons = LessonTranslation::where('lang', $this->lang)
            ->pluck('name', 'lesson_id');
        if ($this->lang == 'vi') {
            $other_language = 'en';
        } else {
            $other_language = 'vi';
        }
        $status = StatusTranslation::where('lang', $this->lang)
            ->pluck('name', 'value');
        return view('admin.tests.create', compact('test', 'lessons', 'status', 'other_language'));
    }

    /**
     * store
     *
     * @param  TestRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TestRequest $request)
    {
        $test_item = $request->except('_token');
        $test_item['slug'] = Str::slug($test_item['name']);
        if ($this->lang == 'vi') {
            $other_language = 'en';
        } else {
            $other_language = 'vi';
        }
        DB::beginTransaction();
        try {
            $test = Test::create(
                [
                    'slug' => $test_item['slug'],
                    'lesson_id' => $test_item['lesson_id'],
                    'total_time' => $test_item['total_time'],
                    'limit' => $test_item['limit'],
                    'total_point' => $test_item['total_point'],
                    'status' => $test_item['status'],
                ]
            );
            TestTranslation::create(
                [
                    'test_id' => $test->id,
                    'lang' => $this->lang,
                    'name' => $test_item['name'],
                    'description' => $request->input('description', ''),
                ]
            );
            if ($request->has('other_name')) {
                TestTranslation::create(
                    [
                        'test_id' => $test->id,
                        'lang' => $other_language,
                        'name' => $test_item['other_name'],
                        'description' => $request->input('description', ''),
                    ]
                );
            }
            $list_question_id = explode(',', $test_item['list_question_id']);
            $test->questions()->attach($list_question_id);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        return redirect(route('test.index'))->with('success_msg', 'Create test success!');
    }

    /**
     * edit
     *
     * @param  Request $request
     * @param  mixed $id
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $test = Test::find($id);
        if ($this->lang == 'vi') {
            $other_language = 'en';
        } else {
            $other_language = 'vi';
        }
        if ($test) {
            $lessons = LessonTranslation::where('lang', $this->lang)
                ->pluck('name', 'lesson_id');
            $status = StatusTranslation::where('lang', $this->lang)
                ->pluck('name', 'value');
            return view('admin.tests.edit', compact('lessons', 'test', 'other_language', 'status'));
        }

        return redirect(route('test.index'))
            ->with('error_msg', 'test is not exitsting!');
    }

    /**
     * update
     *
     * @param  TestRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TestRequest $request, $id)
    {
        $msg = 'Test is not exitsting!';
        $test = Test::find($id);

        if ($test) {

            /** @phpstan-ignore-next-line  */
            $test->lesson_id = $request->input('lesson_id');
            /** @phpstan-ignore-next-line  */
            $test->total_point = $request->input('total_point');
            /** @phpstan-ignore-next-line  */
            $test->status = $request->input('status');
            /** @phpstan-ignore-next-line  */
            $test->total_time = $request->input('total_time');
            /** @phpstan-ignore-next-line  */
            $test->limit = $request->input('limit');
            $test->save();
            $test_trans = TestTranslation::where('test_id', $id)->get();
            foreach ($test_trans as $trans) {
                if ($trans->lang == $this->lang) {
                    /** @phpstan-ignore-next-line  */
                    $trans->name = $request->has('name') ? $request->input('name') : '';
                    /** @phpstan-ignore-next-line  */
                    $trans->description = $request->has('description') ? $request->input('description') : '';
                    $trans->save();
                } else {
                    /** @phpstan-ignore-next-line  */
                    $trans->name = $request->input('other_name', '');
                    /** @phpstan-ignore-next-line  */
                    $trans->description = $request->input('description', '');
                    $trans->save();
                }
            }
            /** @phpstan-ignore-next-line  */
            $test->questions()->sync(explode(',', $request->input('list_question_id')));
            return redirect(route('test.index'))->with('success_mssg', 'Update test is success');
        }
        return redirect(route('test.index'))->with('warning_msg', $msg);
    }

    /**
     * destroy
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $test_id = $request->input('test_id', 0);

        if ($test_id) {
            $test = Test::find($test_id);
            if ($test) {

                /** @phpstan-ignore-next-line  */
                if (!$test->status) {
                    TestTranslation::where('test_id', $test_id)->delete();
                    /** @phpstan-ignore-next-line  */
                    Test::destroy($test_id);
                    return redirect(route('test.index'))

                        /** @phpstan-ignore-next-line  */
                        ->with('success_msg', "Delete test {$test_id} success!");
                } else {
                    return redirect(route('test.index'))
                        /** @phpstan-ignore-next-line  */
                        ->with('warning_msg', "Can not delete test {$test_id} ");
                }
            } else {
                return redirect(route('test.index'))
                    ->with('error_msg', 'Test is not found');
            }
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * getQuestions
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions(Request $request)
    {

        $data['questions'] = DB::table('questions')
            ->leftJoin('question_translations AS qt', 'qt.question_id', 'questions.id')
            ->where('qt.lang', $this->lang)
            ->where('lesson_id', $request->category_id)
            ->get(['questions.id', 'type', 'point', 'qt.content']);
        return response()->json($data);
    }


    /**
     * getTotalPoint
     *
     * @param  Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalPoint(Request $request)
    {
        $pointarr = $request->point;
        $question = array();
        
        /** @phpstan-ignore-next-line  */
        for ($i = 0; $i < count($pointarr); $i++) {
            /** @phpstan-ignore-next-line  */
            $id = (int)$pointarr[$i];
            $question[$i] = DB::table('questions')
                ->leftJoin('question_translations AS qt', 'qt.question_id', 'questions.id')
                ->where('lang', $this->lang)
                ->where('questions.id', $id)
                ->get(['point', 'qt.content', 'type', 'questions.id']);
        }
        $data['list_question'] = $question;
        return response()->json($data);
    }


    /**
     * search
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $data['tests'] = DB::table('tests')
            ->leftJoin('test_translations AS tt', 'test_id', 'tests.id')
            ->join('lesson_translations AS lt', 'tests.lesson_id', 'lt.lesson_id')
            ->leftJoin('status_translations AS ss', 'ss.value', 'status')
            ->where('ss.lang', $this->lang)
            ->where('tt.lang', $this->lang)
            ->where('lt.lang', $this->lang)
            ->whereRaw('match(tt.name) against(?)', array($request->content_search))
            ->get([
                'tests.id',
                'tt.name',
                'slug',
                'lt.name AS lesson_name',
                'tests.lesson_id',
                'tests.status',
                'ss.name AS status_name',
                'total_point',
                'total_time',
                'limit',
                'tt.description',
                'tests.created_at',
                'tests.updated_at',
            ]);
        return response()->json($data);
    }


    /**
     * filter
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $status = [0, 1];
        if ($request->has('status')) $status = $request->status;
        $data['tests'] = DB::table('tests')
            ->leftJoin('test_translations AS tt', 'test_id', 'tests.id')
            ->join('lesson_translations AS lt', 'tests.lesson_id', 'lt.lesson_id')
            ->leftJoin('status_translations AS ss', 'ss.value', 'status')
            ->where('ss.lang', $this->lang)
            ->where('tt.lang', $this->lang)
            ->where('lt.lang', $this->lang)
            ->whereIn('status', $status)
            ->get([
                'tests.id',
                'tt.name',
                'slug',
                'lt.name AS lesson_name',
                'tests.lesson_id',
                'tests.status',
                'ss.name AS status_name',
                'total_point',
                'total_time',
                'limit',
                'tt.description',
                'tests.created_at',
                'tests.updated_at',
            ]);

        return response()->json($data);
    }
}
