@extends('layouts.font_end_app')
@section('title', 'Cowell')

@section('content')
@include('partials/font_end/other_header')

<!-- Page Banner Start -->
<section class="page-banner-area rel z-1 text-white text-center" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="banner-inner rpt-10">
            <h2 class="page-title wow fadeInUp delay-0-2s">Lesson Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb wow fadeInUp delay-0-4s">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">home</a></li>
                    <li class="breadcrumb-item active">Lesson Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <img class="circle-one" src="{{asset('assets/images/shapes/circle-one.png')}}" alt="Circle">
    <img class="circle-two" src="{{asset('assets/images/shapes/circle-two.png')}}" alt="Circle">
</section>
<!-- Page Banner End -->


<!-- Course Details Start -->
<section class="course-details-area pt-130 rpt-100">
    <div class="container">
        <div class="row large-gap">
            <div class="col-lg-8">
                <div class="course-details-content">
                    <h2>{{$lesson->name}}</h2>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width:{{(int)$lesson->progress}}%;" aria-valuenow="{{(int)$lesson->progress}}" aria-valuemin="0" aria-valuemax="100">{{(int)$lesson->progress}}</div>
                    </div>

                    <p>
                        {!! $lesson->content !!}
                    </p>
                    <h3>File in <span style="color: red;">{{$lesson->name}}</span></h3>
                    <div class="faq-accordion pt-10 pb-50 wow fadeInUp delay-0-2s" id="course-faq">
                        <div class="row">
                            @forelse($files as $file)
                            @php
                            $div = explode('.', $file->path);
                            $file_ext = strtolower(end($div));

                            $div_name = explode('/', $file->path);
                            $file_name = strtolower(end($div_name));

                            $permited_ppt = array('ppt', 'pptx', 'pps', 'ppsx');
                            $permited_doc = array('doc', 'docx');
                            $permited_video = array('mp4', 'avi', 'mov', 'flv', 'wmv');
                            @endphp

                            @if($file->type == 1)
                            @php
                            $link = $file->path;
                            $code = explode('=', $link);
                            $link_youtube = end($code);
                            @endphp
                            <iframe src="https://www.youtube.com/embed/{{$link_youtube}}" width="100%" height="315px">
                            </iframe>
                            @elseif($file->type == 2)
                            @if (in_array($file_ext, $permited_ppt) )
                            <div class="col-md-5">
                                <a class="btn btn-outline-danger btn-file" href="{{ asset($file->path) }}" target="_blank"><i class="fas fa-file-powerpoint"></i> {{ $file_name }}</a>
                            </div>
                            @elseif ( in_array($file_ext, $permited_doc) )
                            <div class="col-md-5">
                                <a class="btn btn-outline-primary btn-file" href="{{ asset($file->path) }}" target="_blank"><i class="fas fa-file-word"></i> {{ $file_name }}</a>
                            </div>
                            @elseif ( $file_ext == 'zip' )
                            <div class="col-md-5">
                                <a class="btn btn-outline-warning btn-file" href="{{ asset($file->path) }}" target="_blank"><i class="fas fa-file-archive"></i> {{ $file_name }}</a>
                            </div>
                            @elseif ( $file_ext == 'pdf' || in_array($file_ext, $permited_video) )

                            <iframe src="{{ asset($file->path) }}" width="100%" height="415px">
                            </iframe>
                            @endif

                            @endif
                            <br>
                            @empty
                            No Files
                            @endforelse
                        </div>

                        <button aria-expanded="false" class="btn btn-success" data-toggle="collapse" data-target="#boxFile" style="margin-top: 5px;">
                            Test
                        </button>

                        <div class="collapse mt-4" id="boxFile">
                            <div class="card card-body">
                                <div class="row">
                                    @forelse($tests as $test)
                                    <div class="col-md-4">
                                        <a class="btn btn-outline-success btn-file" href="{{route('font_end.test.index', ['slug'=>$test->slug])}}">
                                            <i class="fas fa-question-circle"></i>
                                            {{ $test->name }}
                                        </a>
                                    </div>
                                    @empty
                                    No Test
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="course-sidebar rmt-75">
                    <div class="widget widget-recent-courses wow fadeInUp delay-0-2s">
                        <h3>{{$course->name}}</h3>
                        <div class="faq-accordion pt-10 pb-50 wow fadeInUp delay-0-2s" id="course-faq">
                            @for($i = 0; $i < count($chapters); $i++) <div class="card">
                                @if($i == 0)
                                <a class="card-header" href="#" data-toggle="collapse" data-target="#{{$chapters[$i]->name}}" aria-expanded="true" aria-controls="{{$chapters[$i]->name}}">
                                    {{$chapters[$i]->name}}
                                    <span class="toggle-btn"></span>
                                </a>
                                <div id="{{$chapters[$i]->name}}" class="collapse show" data-parent="#course-faq">
                                    @else
                                    <a class="collapsed card-header" href="#" data-toggle="collapse" data-target="#{{$chapters[$i]->name}}" aria-expanded="false" aria-controls="{{$chapters[$i]->name}}">
                                        {{$chapters[$i]->name}}
                                        <span class="toggle-btn"></span>
                                    </a>
                                    <div id="{{$chapters[$i]->name}}" class="collapse" data-parent="#course-faq">
                                        @endif

                                        <div class="card-body">
                                            <ul class="course-video-list">
                                                @foreach($chapters[$i]->lessons as $lesson)
                                                <li>
                                                    <a href="{{route('font_end.lesson.detail',['id'=>$lesson->id, 'chapter_id'=>$chapters[$i]->id])}}"><span class="title">{{ $lesson->translate()->name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Course Details End -->
@stop