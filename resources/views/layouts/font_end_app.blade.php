<!DOCTYPE html>
<html lang="en">
<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--====== Title ======-->
    <title>LMS - @yield('title')</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <!--====== Google Fonts ======-->
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600;700&family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/test.css')}}">
    <!--====== Flaticon ======-->
    <link rel="stylesheet" href="{{asset('assets/css/flaticon.min.css')}}">
    <!--====== Font Awesome ======-->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome-5.9.0.min.css')}}">
    <!--====== Bootstrap ======-->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-4.5.3.min.css')}}">
    <!--====== Magnific Popup ======-->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.min.css')}}">
    <!--====== Nice Select ======-->
    <link rel="stylesheet" href="{{asset('assets/css/nice-select.min.css')}}">
    <!--====== jQuery UI ======-->
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
    <!--====== Animate ======-->
    <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
    <!--====== Slick ======-->
    <link rel="stylesheet" href="{{asset('assets/css/slick.min.css')}}">
    <!--====== Main Style ======-->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    
</head>
<body class="home-one">
    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader"></div>

        @yield('content')
        
        <!-- Footer Area Start -->
        <footer class="main-footer bg-blue text-white pt-75">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-sm-4">
                        <div class="footer-widget about-widget">
                            <h5 class="footer-title">About Us</h5>
                            <p>Sit amet consectetur adipiscin seeiusmod tempor incididunt ut dolore magna aliqu asusp disse ultrices gravida commodo</p>
                            <h5 class="pt-5">Follow Us</h5>
                            <div class="social-style-one">
                                <a href="contact.html"><i class="fab fa-facebook-f"></i></a>
                                <a href="contact.html"><i class="fab fa-twitter"></i></a>
                                <a href="contact.html"><i class="fab fa-linkedin-in"></i></a>
                                <a href="contact.html"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="footer-widget menu-widget">
                            <h5 class="footer-title">Courses</h5>
                            <ul>
                                <li><a href="course-details.html">Life Coach</a></li>
                                <li><a href="course-details.html">Business Coach</a></li>
                                <li><a href="course-details.html">Health Coach</a></li>
                                <li><a href="course-details.html">Development</a></li>
                                <li><a href="course-details.html">Web Design</a></li>
                                <li><a href="course-details.html">SEO Optimize</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="footer-widget menu-widget">
                            <h5 class="footer-title">Resources</h5>
                            <ul>
                                <li><a href="contact.html">Community</a></li>
                                <li><a href="contact.html">Support</a></li>
                                <li><a href="contact.html">Video Guides</a></li>
                                <li><a href="contact.html">Documentation</a></li>
                                <li><a href="contact.html">Security</a></li>
                                <li><a href="contact.html">Template</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="footer-widget contact-info-widget">
                                    <h5 class="footer-title">Get In Touch</h5>
                                    <ul>
                                        <li><i class="fas fa-map-marker-alt"></i> 55 Main Street, 2nd Block, New York</li>
                                        <li><i class="far fa-envelope"></i> <a href="mailto:support@gmail.com">support@gmail.com</a></li>
                                        <li><i class="fas fa-phone"></i> <a href="callto:+0123456789">+012 (345) 67 89</a></li>
                                        <li><i class="far fa-clock"></i> Sunday - Friday,<br> 08 am - 05 pm</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="footer-widget video-widget">
                                    <p>Quis autem vel eum iure repre enderit voluptate</p>
                                    <div class="video-widget overlay my-20">
                                        <img src="assets/images/footer/video.jpg" alt="Video">
                                        <a href="https://www.youtube.com/watch?v=9Y7ma241N8k" class="mfp-iframe video-play"><i class="fas fa-play"></i></a>
                                    </div>
                                    <a href="about.html" class="read-more">view more <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-area bg-dark-blue rel">
                <div class="container">
                    <div class="copyright-inner">
                        <p>© 2022.  <a href="index.html">Wellern</a> All rights reserved.</p>
                        <ul class="footer-menu">
                            <li><a href="faqs.html">Faqs</a></li>
                            <li><a href="contact.html">Links</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="contact.html">Payments</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Scroll Top Button -->
                <button class="scroll-top scroll-to-target" data-target="html"><span class="fas fa-angle-double-up"></span></button>
            </div>
        </footer>
        <!-- Footer Area End -->
        
    </div>
    <!--End pagewrapper-->
    
    
    <!--====== Jquery ======-->
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <!--====== Bootstrap ======-->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <!--====== Appear Js ======-->
    <script src="{{asset('assets/js/appear.min.js')}}"></script>
    <!--====== Slick ======-->
    <script src="{{asset('assets/js/slick.min.js')}}"></script>
    <!--====== jQuery UI ======-->
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <!--====== Isotope ======-->
    <script src="{{asset('assets/js/isotope.pkgd.min.js')}}"></script>
    <!--====== Circle Progress bar ======-->
    <script src="{{asset('assets/js/circle-progress.min.js')}}"></script>
    <!--====== Images Loader ======-->
    <script src="{{asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <!--====== Nice Select ======-->
    <script src="{{asset('assets/js/jquery.nice-select.min.js')}}"></script>
    <!--====== Magnific Popup ======-->
    <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
    <!--  WOW Animation -->
    <script src="{{asset('assets/js/wow.min.js')}}"></script>
    <!-- Custom script -->
    <script src="{{asset('assets/js/script.js')}}"></script>
    @yield('js')
</body>
</html>