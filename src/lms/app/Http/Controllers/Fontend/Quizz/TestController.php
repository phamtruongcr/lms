<?php

namespace App\Http\Controllers\Fontend\Quizz;

use App\Http\Controllers\Controller;
use App\Models\Quizz\Test;
use App\Models\Quizz\TestHistory;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * show
     *
     * @param  mixed $slug
     * @return \Illuminate\View\View
     */
    /** @phpstan-ignore-next-line  */
    public function index($slug)
    {
        $user = Sentinel::getUser();
        $test = Test::select([
            'total_point',
            'total_time',
            'slug',
            'tt.name AS name',
            'start_at',
            'finish_at',
        ])
            ->leftJoin('test_translations AS tt', 'tt.test_id', 'tests.id')
            ->leftJoin('student_tests AS st', 'st.test_id', 'tests.id')
            /** @phpstan-ignore-next-line  */
            ->where('st.student_id', $user->id)
            ->where('tt.lang', $this->lang)
            ->where('slug', $slug)->first();
        $his_tests = DB::table('test_histories AS th')
            ->leftJoin('student_tests AS st', 'st.id', 'th.student_test_id')
            ->leftJoin('tests', 'tests.id', 'st.test_id')
            ->where('tests.slug', $slug)
            /** @phpstan-ignore-next-line  */
            ->where('st.student_id', $user->id)
            ->get();
        return view('font_end.tests.index', compact('test', 'his_tests'));
    }
    /**
     * show
     *
     * @param  mixed $slug
     * @return \Illuminate\View\View
     */
    /** @phpstan-ignore-next-line  */
    public function show($slug)
    {
        $questions = DB::table('test_questions AS tq')
            ->leftJoin('tests', 'tests.id', 'tq.test_id')
            ->leftJoin('question_translations AS qt', 'qt.question_id', 'tq.question_id')
            ->leftJoin('questions', 'questions.id', 'tq.question_id')
            ->where('tests.slug', $slug)
            ->where('qt.lang', $this->lang)
            ->get([
                'tq.question_id',
                'tests.slug',
                'tests.total_time',
                'questions.point',
                'qt.content',
                'tq.test_id',
                'questions.type'
            ]);
        $cnt = 0;
        $ques_answers = array();
        foreach ($questions as $question) {
            $tmp = DB::table('question_answers AS qa')
                ->leftJoin('answer_translations AS at', 'at.answer_id', 'qa.answer_id')
                ->where('at.lang', $this->lang)
                /** @phpstan-ignore-next-line  */
                ->where('qa.question_id', $question->question_id)
                ->get(['qa.answer_id', 'at.content', 'qa.question_id']);
            $ques_answers[$cnt] = $tmp;

            $cnt++;
        }
        return view('font_end.tests.detail', compact('questions', 'ques_answers', 'cnt'));
    }
    /**
     * getPoint
     *
     * @param  Request $request
     * st
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPoint(Request $request)
    {
        $list_key = $request->key_answer;
        $score = 0;
        /** @phpstan-ignore-next-line  */
        foreach ($list_key as $key1 => $value) {
            $type = DB::table('questions')
                ->where('id', $key1)
                ->sum('type');
            if ($type == 1) {
                $tmp = DB::table('question_answers AS qa')
                    ->leftJoin('questions', 'questions.id', 'qa.question_id')
                    ->where('qa.question_id', $key1)
                    ->where('qa.answer_id', $value)
                    ->where('qa.is_true', 1)
                    ->sum('questions.point');
                $score += $tmp;
            }
            if ($type == 2) {
                /** @phpstan-ignore-next-line  */
                $value = explode(',', (string)$value);
                if (sizeof($value) < 2) {
                    continue;
                } else {
                    $tmp = 1;
                    foreach ($value as $val) {
                        $tmp1 = DB::table('question_answers AS qa')
                            ->leftJoin('questions', 'questions.id', 'qa.question_id')
                            ->where('qa.question_id', $key1)
                            ->where('qa.answer_id', $val)
                            ->where('qa.is_true', 0)
                            ->sum('questions.point');
                        if ($tmp1 > 0) {
                            $tmp = 0;
                        }
                    }
                    if ($tmp) {
                        $score += DB::table('questions')
                            ->where('id', $key1)
                            ->sum('questions.point');
                    }
                }
            }
        }
        $data['score'] = $score;
        return response()->json($data);
    }
    public function storeTest(Request $request)
    {
        $student_test = DB::table('student_tests')
            ->where('student_id', $request->user_id)
            ->where('test_id', $request->test_id)
            ->get(['id', 'attempt', 'max_score']);
        DB::beginTransaction();
        try {
            TestHistory::create(
                [
                    /** @phpstan-ignore-next-line  */
                    'student_test_id' => $student_test[0]->id,
                    'score' => $request->score,
                    'index' => 1,
                    'key' => '1'
                ]
            );
            $attempt = DB::table('test_history')
                /** @phpstan-ignore-next-line  */
                ->where('student_test_id', $student_test[0]->id)
                ->sum('index');
            $point = DB::table('test_history')
                /** @phpstan-ignore-next-line  */
                ->where('id', $student_test[0]->id)
                ->sum('score');
            $max_score = $attempt ? $point / $attempt : 0;
            $test = Test::find($request->test_id);
            $test->students()->sync($request->user_id, ['attempt' => $attempt, 'max_score' => $max_score]);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        return redirect(route('font_end.test.index', ['slug' => $request->link_slug]));
    }

    public function timer()
    {
        session_start();
        $myTime = 5 *60;

        if( !isset($_SESSION['time']) ){
            $_SESSION['time'] = time();
        }else{
            $diff = time() - $_SESSION['time'];
            $diff = $myTime - $diff;

            $minute = (int)($diff/60);
            $second = $diff%60;

            $show = $minute.":".$second;

            if($diff == 0 || $diff < 0 ){
                echo "Timeout";
            }else{
                echo $show;
            }
        }
    }
}
