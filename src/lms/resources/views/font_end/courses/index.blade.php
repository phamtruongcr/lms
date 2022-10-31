@extends('layouts.font_end_app')
@section('title', 'Cowell')

@section('content')
@include('partials/font_end/other_header')

<!-- Page Banner Start -->
<section class="page-banner-area rel z-1 text-white text-center" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="banner-inner rpt-10">
            <h2 class="page-title wow fadeInUp delay-0-2s">Courses</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb wow fadeInUp delay-0-4s">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">home</a></li>
                    <li class="breadcrumb-item active">Courses</li>
                </ol>
            </nav>
        </div>
    </div>
    <img class="circle-one" src="{{asset('assets/images/shapes/circle-one.png')}}" alt="Circle">
    <img class="circle-two" src="{{asset('assets/images/shapes/circle-two.png')}}" alt="Circle">
</section>
<!-- Page Banner End -->


<!-- Course Left Start -->
<section class="course-left-area py-130 rpy-100">
    <div class="container">
        <div class="row large-gap">
            <div class="col-lg-4">
                <div class="course-sidebar rmb-55">
                    <div class="widget widget-search wow fadeInUp delay-0-2s">
                        <form action="#">
                            <input type="text" placeholder="Search Here" required>
                            <button type="submit" class="searchbutton fa fa-search"></button>
                        </form>
                    </div>

                    <div class="widget widget-radio wow fadeInUp delay-0-2s">
                        <h4 class="widget-title">Filter By Level</h4>
                        <form class="newsletter-form" action="#">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="all-level" name="filter" checked>
                                <label class="custom-control-label" for="all-level">Show All Level <span>(55)</span></label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="beginner-level" name="filter">
                                <label class="custom-control-label" for="beginner-level">Beginner Level <span>(20)</span></label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="advance-level" name="filter">
                                <label class="custom-control-label" for="advance-level">Advance level <span>(45)</span></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">

                <div class="course-grids">
                    <div class="shop-shorter mb-40 wow fadeInUp delay-0-2s">
                        <ul class="grid-list">
                            <li><a href="#"><i class="fas fa-list-ul"></i></a></li>
                            <li><a href="#" class="active"><i class="fas fa-border-all"></i></a></li>
                        </ul>
                        <div class="products-dropdown">
                            <select>
                                <option value="default">Filter by</option>
                                <option value="new" selected="">Latest</option>
                                <option value="old">Oldest</option>
                                <option value="hight-to-low">High To Low</option>
                                <option value="low-to-high">Low To High</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($courses as $course)
                        <div class="col-md-6">
                            <div class="coach-item wow fadeInUp delay-0-4s">
                                <div class="coach-image">
                                    <a href="course-grid.html" class="category">{{$course->name_group}}</a>
                                    @if($course->name_image)
                                    <img src="{{ $course->name_image }}" style="width: 370px; height: 250px;" alt="{{$course->name}}">
                                    @else
                                    <img src="{{ 'files/thumb.jpg' }}" style="width: 370px; height: 250px;" alt="{{$course->name}}">
                                    @endif
                                </div>
                                <div class="coach-content">
                                    <h4>
                                        <a href="{{route('font_end.course.detail', ['id'=>$course->id])}}">
                                            {{ (strlen($course->name) > 40) ? textShorten( $course->name, 40) : $course->name }}
                                        </a>
                                    </h4>
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
                    <ul class="pagination flex-wrap mt-10">
                        {{$courses->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Course Left End -->
@stop

