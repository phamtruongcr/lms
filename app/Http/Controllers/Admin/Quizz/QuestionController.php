<?php

namespace App\Http\Controllers\Admin\Quizz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Quizz\QuestionRequest;
use App\Models\Course\LessonTranslation;
use App\Models\Quizz\Question;
use App\Models\Quizz\QuestionTranslation;
use App\Models\StatusTranslation;
use App\Models\TypeTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    protected function index()
    {
        $questions = Question::select([
            'questions.id',
            'qt.content',
            'slug',
            'lt.name AS lesson_name',
            'questions.lesson_id',
            'questions.status',
            'ss.name AS status_name',
            'type',
            'ts.name AS type_name',
            'point',
            'questions.created_at',
            'questions.updated_at',
        ])
            ->leftJoin('question_translations AS qt', 'question_id', 'questions.id')
            ->join('lesson_translations AS lt', 'questions.lesson_id', 'lt.lesson_id')
            ->leftJoin('type_translations AS ts', 'ts.value', 'type')
            ->leftJoin('status_translations AS ss', 'ss.value', 'status')
            ->where('qt.lang', $this->lang)
            ->where('ts.lang', $this->lang)
            ->where('ss.lang', $this->lang)
            ->orderBy('questions.id', 'desc')
            ->paginate();
        $types = TypeTranslation::select([
            'name',
            'value'
        ])
            ->where('lang', $this->lang)
            ->paginate();
        $status = StatusTranslation::select([
            'value',
            'name',
        ])
            ->where('lang', $this->lang)
            ->paginate();
        return view('admin.questions.index', compact('questions', 'types', 'status'));
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
        $question = new Question();
        $lessons = LessonTranslation::where('lang', $this->lang)
            ->pluck('name', 'lesson_id');
        if ($this->lang == 'vi') {
            $other_language = 'en';
        } else {
            $other_language = 'vi';
        }
        $types = TypeTranslation::where('lang', $this->lang)
            ->pluck('name', 'value');
        $status = StatusTranslation::where('lang', $this->lang)
            ->pluck('name', 'value');
        return view('admin.questions.create', compact('question', 'lessons', 'types', 'status', 'other_language'));
    }
    /**
     * store
     *
     * @param  QuestionRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionRequest $request)
    {
        $question_item = $request->except('_token');
        $question_item['slug'] = Str::slug($question_item['content']);
        if ($this->lang == 'vi') {
            $other_language = 'en';
        } else {
            $other_language = 'vi';
        }
        DB::beginTransaction();
        try {
            $question = Question::create(
                [
                    'slug' => $question_item['slug'],
                    'lesson_id' => $question_item['lesson_id'],
                    'point' => $question_item['point'],
                    'status' => $question_item['status'],
                    'type' => $question_item['type'],
                ]
            );
            QuestionTranslation::create(
                [
                    'question_id' => $question->id,
                    'lang' => $this->lang,
                    'content' => $question_item['content'],
                ]
            );
            if ($request->has('other_content')) {
                QuestionTranslation::create(
                    [
                        'question_id' => $question->id,
                        'lang' => $other_language,
                        'content' => $question_item['other_content'],
                    ]
                );
            }
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        return redirect(route('question.index'))->with('success_msg', 'Create question success!');
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
        $question = Question::find($id);
        if ($this->lang == 'vi') {
            $other_language = 'en';
        } else {
            $other_language = 'vi';
        }
        if ($question) {
            $lessons = LessonTranslation::where('lang', $this->lang)
                ->pluck('name', 'lesson_id');
            $types = TypeTranslation::where('lang', $this->lang)
                ->pluck('name', 'value');
            $status = StatusTranslation::where('lang', $this->lang)
                ->pluck('name', 'value');
            return view('admin.questions.edit', compact('lessons', 'question', 'other_language', 'types', 'status'));
        }

        return redirect(route('question.index'))
            ->with('error_msg', 'question is not exitsting!');
    }
    /**
     * update
     *
     * @param  QuestionRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionRequest $request, $id)
    {
        $msg = 'Question is not exitsting!';
        $question = Question::find($id);
        if ($question) {
            /** @phpstan-ignore-next-line  */
            $question->lesson_id = $request->input('lesson_id');
            /** @phpstan-ignore-next-line  */
            $question->point = $request->input('point');
            /** @phpstan-ignore-next-line  */
            $question->type = $request->input('type');
            /** @phpstan-ignore-next-line  */
            $question->status = $request->input('status');
            $question->save();
            $question_trans = QuestionTranslation::where('question_id', $id)->get();
            foreach ($question_trans as $trans) {
                if ($trans->lang == $this->lang) {
                    /** @phpstan-ignore-next-line  */
                    $trans->content = $request->input('content', '');
                    $trans->save();
                } else {
                    /** @phpstan-ignore-next-line  */
                    $trans->content = $request->input('other_content', '');
                    $trans->save();
                }
            }
            return redirect(route('question.index'))->with('success_mssg', 'Update question is success');
        }
        return redirect(route('question.index'))->with('warning_msg', $msg);
    }

    /**
     * destroy
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $question_id = $request->input('question_id', 0);
        if ($question_id) {
            $question = Question::find($question_id);
            if ($question) {
                /** @phpstan-ignore-next-line  */
                if (!$question->status) {
                    QuestionTranslation::where('question_id', $question_id)->delete();
                    /** @phpstan-ignore-next-line  */
                    Question::destroy($question_id);
                    return redirect(route('question.index'))
                        /** @phpstan-ignore-next-line  */
                        ->with('success_msg', "Delete question {$question_id} success!");
                } else {
                    return redirect(route('question.index'))
                    
                    /** @phpstan-ignore-next-line  */
                        ->with('warning_msg', "Can not delete question {$question_id} ");
                }
            } else {
                return redirect(route('question.index'))
                    ->with('error_msg', 'Question is not found');
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
    public function searchAjax(Request $request)
    {
        $data['questions'] = DB::table('questions')
            ->leftJoin('question_translations AS qt', 'question_id', 'questions.id')
            ->join('lesson_translations AS lt', 'questions.lesson_id', 'lt.lesson_id')
            ->leftJoin('type_translations AS ts', 'ts.value', 'type')
            ->leftJoin('status_translations AS ss', 'ss.value', 'status')
            ->where('qt.lang', $this->lang)
            ->where('lt.lang', $this->lang)
            ->where('ts.lang', $this->lang)
            ->where('ss.lang', $this->lang)
            ->whereRaw('match(qt.content) against(?)', array($request->content_search))
            ->get([
                'qt.content', 'type', 'point', 'questions.lesson_id', 'lt.name AS lesson_name', 'ss.name AS status_name', 'ts.name AS type_name', 'questions.created_at',
                'questions.updated_at'
            ]);

        return response()->json($data);
    }
    /**
     * getTotalPoint
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterQuestions(Request $request)
    {
        $type = [1, 2, 3];
        $status = [0, 1];
        if ($request->has('type')) $type = $request->type;
        if ($request->has('status')) $status = $request->status;
        $data['questions'] = DB::table('questions')
            ->leftJoin('question_translations AS qt', 'question_id', 'questions.id')
            ->join('lesson_translations AS lt', 'questions.lesson_id', 'lt.lesson_id')
            ->leftJoin('type_translations AS ts', 'ts.value', 'type')
            ->leftJoin('status_translations AS ss', 'ss.value', 'status')
            ->where('qt.lang', $this->lang)
            ->where('lt.lang', $this->lang)
            ->where('ts.lang', $this->lang)
            ->where('ss.lang', $this->lang)
            ->whereIn('questions.type', $type)
            ->whereIn('questions.status', $status)
            ->get([
                'qt.content', 'type', 'point', 'questions.lesson_id', 'lt.name AS lesson_name', 'ss.name AS status_name', 'ts.name AS type_name', 'questions.created_at',
                'questions.updated_at'
            ]);

        return response()->json($data);
    }
}
