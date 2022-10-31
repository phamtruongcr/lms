@extends('layouts.font_end_app')
@section('title', 'Cowell')

@section('content')

@include('partials/font_end/header')

<!-- Hero Section Start -->
<section class="hero-section rel z-1 pt-150 rpt-135 pb-75 rpb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-content rpt-25 rmb-75">
                    <span class="sub-title style-two mb-20 wow fadeInUp delay-0-2s">Coaching & Speker</span>
                    <h1 class="mb-20 wow fadeInUp delay-0-4s">Build Bright Life? Take Our Life Coach</h1>
                    <p class="wow fadeInUp delay-0-6s">Sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt labore dolore magna aliqua suspendisse ultrices gravida.</p>
                    <div class="hero-btn mt-30 wow fadeInUp delay-0-8s">
                        <a href="course-grid.html" class="theme-btn">Get Your Free Coach <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-right-images text-lg-right wow fadeInUp delay-0-2s">
                    <img src="assets/images/hero/hero-right.png" alt="Hero">
                </div>
            </div>
        </div>
    </div>
    <span class="bg-text">coach</span>
    <div class="page-title-actions mr-5" style="font-size: 20px;">
        <form name="cd">
            <input type="hidden" name="" id="timeExamLimit" value="5:00">
            <label>Remaining Time : </label>
            <input style="border:none;background-color: transparent;color:blue;font-size: 25px;" name="disp" type="text" class="clock" id="txt" value="00:00" size="5" readonly="true" />
        </form>

        <p id="duration" ></p>
    </div>
</section>
<!-- Hero Section End -->


<!-- Coach Section Start -->
<section class="coach-section rel z-1 pt-120 rpt-90 pb-100 rpb-70 bg-lighter">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-8">
                <div class="section-title text-center mb-40">
                    <h2>Courses</h2>
                </div>
            </div>
        </div>
        <div class="row coach-active justify-content-center">
            @foreach($courses as $course)
            <div class="col-lg-4 col-md-6 item">
                <div class="coach-item wow fadeInUp delay-0-2s">
                    <div class="coach-image">
                        <img src="{{ asset(($course->name_image)?$course->name_image:'files/thumb.jpg') }}" style="width: 370px; height: 250px;" alt="{{ $course->name }}">
                    </div>
                    <div class="coach-content">
                        <h4><a href="{{route('font_end.course.detail', ['id'=>$course->id])}}">{{ (strlen($course->name) > 40) ? textShorten( $course->name, 40) : $course->name }}</a></h4>
                        <ul class="coach-footer">
                            <li>
                                <i class="far fa-clock"></i>
                                <span>{{ Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($course->finish_at)->format('d/m/Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-8">
                <div class="section-title text-center mb-40">
                    <h3 class="float-center">
                        <a href="{{route('font_end.course.index')}}" class="">
                            <i class="fas fa-angle-double-down"></i>
                        </a>
                    </h3>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Coach Section End -->

@stop

@section('js')
<script>
  // timer will start when document is loaded 
  $(document).ready( function () { 
    setInterval(() => {
        $.ajax({
            url:"{{ url('/timer') }}",  //path to your file
            success:function(data) {
               // do your code here
               $('#duration').text(data);

            }
        }); 
    }, 1000);

  });

</script>
@stop