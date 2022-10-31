@extends('layouts.font_end_app')
@section('title', 'Cowell')

@section('content')
@include('partials/font_end/other_header')
<!-- Page Banner Start -->
<section class="page-banner-area rel z-1 text-white text-center" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="banner-inner rpt-10">
            <h2 class="page-title wow fadeInUp delay-0-2s">Test</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb wow fadeInUp delay-0-4s">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="index.html">Lesson</a></li>
                    <li class="breadcrumb-item active">Test Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <img class="circle-one" src="{{asset('assets/images/shapes/circle-one.png')}}" alt="Circle">
    <img class="circle-two" src="{{asset('assets/images/shapes/circle-two.png')}}" alt="Circle">
</section>
<!-- Page Banner End -->


<section id="region-main" class="content-col col-md-9 order-2" style="padding-left:200px;">
    <div id="page-content">
		<span class="notifications" id="user-notifications"></span>					                	
        <div role="main">
            <span id="maincontent"></span>
            <h2>{{ $test->name }}</h2>
            <div class="box py-3 quizinfo" style="text-align: center;">
                <p>This quiz opened on {{ $test->start_at }}</p>
                <p>This quiz closed on {{ $test->finish_at }}</p>
                <p>Time limit: {{ $test->total_time }} mins</p>
                <p>Grading method: Average grade</p>
                </div><h3>Summary of your previous attempts</h3><div class="theme-table-wrap"><table class="generaltable quizattemptsummary table table-striped">
                <thead>
                <tr>
                <th class="header c0" style="text-align:center;" scope="col">Attempt</th>
                <th class="header c1" style="text-align:left;" scope="col">State</th>
                <th class="header c3" style="text-align:center;" scope="col">Grade / {{ $test->total_point }}</th>
                <th class="header c4 lastcol" style="text-align:center;" scope="col">Review</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($his_tests as $his_test)
                    <tr class="">
                        <td class="cell c0" style="text-align:center;">{{ $his_test->index }}</td>
                        <td class="cell c1" style="text-align:left;">Finished<span class="statedetails">Submitted {{ $his_test->updated_at}}</span></td>
                        <td class="cell c3" style="text-align:center;">{{ $his_test->score }}</td>
                        <td class="cell c4 lastcol" style="text-align:center;"><span class="noreviewmessage">Not permitted</span></td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
                </table>
            </div>
            <div class="box py-3 quizattempt">
                <div class="continuebutton">
                    <form method="get" action="../detail/{{$test->slug}}">
                            <input type="hidden" name="id" value="1009">
                        <button type="submit" class="btn btn-secondary" id="single_button63181725cc74e39" title="">Attempt quizz</button>
                    </form>
                </div>
            </div>
        </div>                                        

@stop