@extends('layouts.font_end_app')
@section('title', 'Cowell')

@section('content')


@for($tmp=0; $tmp < sizeof($questions);$tmp++) <div>

    <div id="question-1759699-1" class="que multichoice deferredfeedback notyetanswered">
        <div class="info">
            <h3 class="no">Question <span class="qno"> {{ $tmp+1 }}</span></h3>
            <div class="state">Not yet answered</div>
            <div class="grade" style="display:inline">Marked out of {{ $questions[$tmp]->point}}</div>
        </div>
        <div class="content">
            <div class="formulation clearfix">
                <h4 class="accesshide">Question text</h4>
                <div class="qtext">
                    <p>{{ $questions[$tmp]->content }}</p>
                </div>
                @if($questions[$tmp]->type==1)
                <div class="ablock">
                    <div class="prompt">Select one:</div>
                    <div class="answer">

                        @for($i=0;$i < 4; $i++) <div class="r0"><input type="radio" name="{{$questions[$tmp]->question_id}}" value="{{$ques_answers[$tmp][$i]->answer_id}}" id="{{ $questions[$tmp]->test_id }}:{{$tmp+1}}_answer{{$i}}">
                            <label for="{{ $questions[$tmp]->test_id }}:{{$tmp+1}}_answer{{$i}}" class="ml-1">
                                <span class="answernumber">{{ $i+1 }}.</span>{{$ques_answers[$tmp][$i]->content}}
                            </label>
                    </div>
                    @endfor
                </div>
            </div>
            @endif
            @if($questions[$tmp]->type==2)
            <div class="ablock">
                <div class="prompt">Multi Select:</div>
                <div class="answer">

                    @for($i=0;$i < 4; $i++) <div class="r0"><input type="checkbox" name="{{$questions[$tmp]->question_id}}" value="{{$ques_answers[$tmp][$i]->answer_id}}" id="{{ $questions[$tmp]->test_id }}:{{$tmp+1}}_answer{{$i}}">
                        <label for="{{ $questions[$tmp]->test_id }}:{{$tmp+1}}_answer{{$i}}" class="ml-1">
                            <span class="answernumber">{{ $i+1 }}.</span>{{$ques_answers[$tmp][$i]->content}}
                        </label>
                </div>
                @endfor
            </div>
        </div>
        @endif
        @if($questions[$tmp]->type==3)
        <div class="ablock">
            <label for="{{ $questions[$tmp]->test_id }}:{{$tmp+1}}_answer">Answer</label>
            <input type="text" name="{{$questions[$tmp]->question_id}}" id="{{ $questions[$tmp]->test_id }}:{{$tmp+1}}_answer" value="" class="">
        </div>
        @endif
    </div>
    </div>
    </div>
    </div>

    @endfor

    <br>
    <form action="{{ route('font_end.test.storeTest',['slug'=>$questions[1]->slug]) }}" method="post">
        @csrf
    <input type="hidden" name="user_id" id="user_id" value="{{ Sentinel::getUser()->id}}">
    <input type="hidden" name="test_id" id="test_id" value="{{ $questions[1]->test_id }}">
    <input type="hidden" name="total_time" id="total_time" value="{{ $questions[1]->total_time }}">
    <input type="hidden" name="link_slug" id="link_slug" value="{{ $questions[1]->slug }}">
    <input type="hidden" name="score" id="curr_score" value="">
    <button type="submit" id="btn_submit" class="btn btn-primary" style="margin-left:48%;">
        Submit
    </button>
    </form>


    <br>
    @stop
    @section('js')
    <script>
        $('input').change( function() {
            var ele = document.getElementsByTagName('input');
            var key = new Array();
            for (i = 0; i < ele.length; i++) {

                if (ele[i].type == "radio") {

                    if (ele[i].checked) {
                        key[ele[i].name] = ele[i].value;
                    }
                }
                if (ele[i].type == "checkbox") {

                    if (ele[i].checked) {
                        if (key[ele[i].name]) {
                            key[ele[i].name] += ',' + ele[i].value;
                        } else {
                            key[ele[i].name] = ele[i].value;
                        }
                    }
                }
                if (ele[i].type == "text") {
                    key[ele[i].name] = ele[i].value;
                }
            }
            $.ajax({
                url: "{{ url('test/getPoint') }}",
                type: "POST",
                data: {
                    key_answer: key,
                    user_id: $('#user_id').val(),
                    test_id: $('#test_id').val(),
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data.score);
                    $('#curr_score').val(data.score);
                }
            })
        });
        setTimeout("$('#btn_submit').click()", $('#total_time').val() * 60 * 1000);
    </script>

    @stop