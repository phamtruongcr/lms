<?php

namespace App\Http\Controllers\Admin\Quizz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Quizz\AnswerRequest;
use App\Models\Course\LessonTranslation;
use App\Models\Quizz\Answer;
use App\Models\Quizz\AnswerTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $answers = Answer::select([
            'answers.id',
            'at.content',
            'lt.lesson_id',
            'lt.name AS lesson_name',
            'status',
            'created_at',
            'updated_at',
        ])
            ->leftJoin('answer_translations AS at', 'answer_id', 'answers.id')
            ->join('lesson_translations AS lt', 'answers.lesson_id', 'lt.lesson_id')
            ->where('at.lang', $this->lang)
            ->orderBy('answers.id', 'desc')
            ->paginate();
        return view('admin.answers.index', compact('answers'));
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
        $answer = new Answer();
        $lessons = LessonTranslation::where('lang', $this->lang)
            ->pluck('name', 'lesson_id');
        if ($this->lang == 'vi') {
            $language = 'en';
        } else {
            $language = 'vi';
        }
        return view('admin.answers.create', compact('lessons', 'answer', 'language'));
    }

    /**
     * store
     *
     * @param  AnswerRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AnswerRequest $request)
    {
        $answer_item = $request->except('_token');
        if ($this->lang == 'vi') {
            $language = 'en';
        } else {
            $language = 'vi';
        }
        DB::beginTransaction();
        try {
            $answer = Answer::create(
                [
                    'lesson_id' => $answer_item['lesson_id'],
                ]
            );
            AnswerTranslation::create(
                [
                    'answer_id' => $answer->id,
                    'lang' => $this->lang,
                    'content' => $answer_item['content'],
                ]
            );
            if ($request->has('other_content')) {
                AnswerTranslation::create(
                    [
                        'answer_id' => $answer->id,
                        'lang' => $language,
                        'content' => $answer_item['other_content'],
                    ]
                );
            }
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        return redirect(route('answer.index'))->with('success_msg', 'Create answer success!');
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
        $answer = Answer::find($id);
        if ($this->lang == 'vi') {
            $other_language = 'en';
        } else {
            $other_language = 'vi';
        }
        if ($answer) {
            $lessons = LessonTranslation::where('lang', $this->lang)
                ->pluck('name', 'lesson_id');
            return view('admin.answers.edit', compact('lessons', 'answer', 'other_language'));
        }
        return redirect(route('answer.index'))
            ->with('error_msg', 'Answer is not exitsting!');
    }

    /**
     * update
     *
     * @param  AnswerRequest $request
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AnswerRequest $request, $id)
    {
        $msg = 'Answer is not exitsting!';
        $answer = Answer::find($id);
        if ($answer) {
            /** @phpstan-ignore-next-line  */
            $answer->lesson_id = $request->input('lesson_id');
            /** @phpstan-ignore-next-line  */
            $answer->save();
            $answer_trans = AnswerTranslation::where('answer_id', $id)->get();
            foreach ($answer_trans as $trans) {
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
            return redirect(route('answer.index'))->with('success_mssg', 'Update answer is success');
        }
        return redirect(route('answer.index'))->with('warning_msg', $msg);
    }

    /**
     * destroy
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $answer_id = $request->input('answer_id', 0);
        if ($answer_id) {
            $answer = Answer::find($answer_id);
            if ($answer) {
                /** @phpstan-ignore-next-line  */
                if (!$answer->status) {
                    AnswerTranslation::where('answer_id', $answer_id)->delete();
                    /** @phpstan-ignore-next-line  */
                    Answer::destroy($answer_id);
                    return redirect(route('answer.index'))
                        /** @phpstan-ignore-next-line  */
                        ->with('success_msg', "Delete answer {$answer_id} success!");
                } else {
                    return redirect(route('answer.index'))
                        /** @phpstan-ignore-next-line  */
                        ->with('warning_msg', "Can not delete answer {$answer_id} ");
                }
            } else {
                return redirect(route('answer.index'))
                    ->with('error_msg', 'Answer is not found');
            }
        } else {
            throw new ModelNotFoundException();
        }
    }
}
