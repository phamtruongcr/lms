@extends('layouts.font_end_app')
@section('title', 'Cowell')

@section('content')
@include('partials/font_end/other_header')

<!-- Page Banner Start -->
<section class="page-banner-area rel z-1 text-white text-center" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="banner-inner rpt-10">
            <h2 class="page-title wow fadeInUp delay-0-2s">Course Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb wow fadeInUp delay-0-4s">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">home</a></li>
                    <li class="breadcrumb-item active">Course Details</li>
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
                    <h2>{{$course->name}}</h2>
                    <ul class="author-date-enroll">
                        <li><i class="far fa-clock"></i>
                            {{ Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($course->finish_at)->format('d/m/Y') }}
                        </li>
                    </ul>
                    @if(isset($course->name_image))
                    <div class="image mb-35">
                        <img src="{{ asset($course->name_image) }}" alt="{{$course->name}}" style="width: 735px; height: 430px;">
                    </div>
                    @endif
                    <p>
                        {!! $course->description !!}
                    </p>
                    <h3>Course Curriculum in <span style="color: red;">{{$course->name}}</span></h3>
                    <div class="faq-accordion pt-10 pb-50 wow fadeInUp delay-0-2s" id="course-faq">
                    @for($i = 0; $i < count($chapters); $i++) 
                        <div class="card">
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
            <div class="col-lg-4">
                <div class="course-sidebar rmt-75">
                    <div class="widget widget-course-details wow fadeInUp delay-0-2s">
                        @if(isset($course->name_image))
                        <div class="widget-video">
                            <img src="{{ asset($course->name_image) }}" alt="{{$course->name}}" style="width: 300px; height: 200px;">
                        </div>
                        @endif

                        <ul class="course-details-list mb-25">
                            <li><i class="far fa-clipboard"></i> <span>Subject</span> <b>{{$course->name}}</b></li>
                            <li><i class="far fa-clock"></i> <span>Time</span>
                                <b>
                                    {{ Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($course->finish_at)->format('d/m/Y') }}
                                </b>
                            </li>
                            <li><i class="far fa-play-circle"></i> <span>Chapters</span> <b>{{count($chapters)}} Chapters</b></li>
                        </ul>
                    </div>
                    <div class="widget widget-recent-courses wow fadeInUp delay-0-2s">
                        <h4 class="widget-title">Group Courses</h4>
                        <ul>
                            @foreach($courses as $item_course)
                            @if($course->id != $item_course->id
                            && $course->group_id == $item_course->group_id)
                            <li>
                                <div class="image">
                                    @if($item_course->name_image)
                                    <img src="{{ asset($item_course->name_image) }}" style="width: 85px; height: 70px;" alt="{{$item_course->name}}">
                                    @else
                                    <img src="{{ asset('files/thumb.jpg') }}" style="width: 85px; height: 70px;" alt="{{$item_course->name}}">
                                    @endif
                                </div>
                                <div class="content">
                                    <h6>
                                        <a href="{{route('font_end.course.detail', ['id'=>$item_course->id])}}">
                                            {{ (strlen($item_course->name) > 40) ? textShorten( $item_course->name, 40) : $item_course->name }}
                                        </a>
                                    </h6>
                                </div>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Course Details End -->
@stop