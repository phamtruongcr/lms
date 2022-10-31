@extends('layouts.font_end_app')
@section('title', 'Cowell')

@section('content')
@include('partials/font_end/other_header')

<!-- Page Banner Start -->
<section class="page-banner-area rel z-1 text-white text-center" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="banner-inner rpt-10">
            <h2 class="page-title wow fadeInUp delay-0-2s">404</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb wow fadeInUp delay-0-4s">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">home</a></li>
                    <li class="breadcrumb-item active">404</li>
                </ol>
            </nav>
        </div>
    </div>
    <img class="circle-one" src="assets/images/shapes/circle-one.png" alt="Circle">
    <img class="circle-two" src="assets/images/shapes/circle-two.png" alt="Circle">
</section>
<!-- Page Banner End -->


<!-- Error Section Start -->
<section class="error-section py-130 rpy-100">
    <div class="container">
        <div class="error-inner text-center wow fadeInUp delay-0-2s">
            <img src="assets/images/404.png" alt="Error">
            <div class="section-title mt-50 mb-40">
                <h2>OPPS! This Page Are Can’t Be Found</h2>
            </div>
            <a href="{{route('home')}}" class="theme-btn style-two">goto home <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
<!-- Error Section End -->
@stop