<!-- main header -->
<header class="main-header header-two">
    <!-- Header-Top -->
    <div class="header-top bg-light-blue text-white">
        <div class="container-fluid">
            <div class="top-inner">
                <div class="top-left">
                    <p><i class="far fa-clock"></i> <b>Working Hours</b> : Manday - Friday, 08am - 05pm</p>
                </div>
                <div class="top-right d-flex align-items-center">
                    <div class="social-style-two">
                        <a href="contact.html"><i class="fab fa-twitter"></i></a>
                        <a href="contact.html"><i class="fab fa-facebook-f"></i></a>
                        <a href="contact.html"><i class="fab fa-instagram"></i></a>
                        <a href="contact.html"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                    <ul class="top-menu">
                        <li><a href="about.html">Setting & Privacy</a></li>
                        <li><a href="faqs.html">Faqs</a></li>
                        <li><a href="about.html">About</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header-Upper -->
    <div class="header-upper">
        <div class="container-fluid clearfix">

            <div class="header-inner d-flex align-items-center justify-content-between">
                <div class="logo-outer d-lg-flex align-items-center">
                    <div class="logo"><a href="index.html"><img src="{{asset('assets/images/logos/logo.png')}}" style="width: 100px; height: 100px;" alt="Logo" title="Logo"></a></div>
                    <nav class="main-menu navbar-expand-lg">
                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <li class="dropdown"><a href="#">Lang</a>
                                    <ul>
                                        <li><a class="dropdown-item" href="?lang=vi">VI</a></li>
                                        <li><a class="dropdown-item" href="?lang=en">EN</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <div class="nav-outer clearfix">
                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-lg">
                        <div class="navbar-header">
                            <div class="mobile-logo bg-green br-10 p-15">
                                <a href="index.html">
                                    <img src="{{asset('assets/images/logos/logo.png')}}" alt="Logo" title="Logo">
                                </a>
                            </div>

                            <!-- Toggle Button -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <li>
                                    <a href="{{route('home')}}">Home</a>
                                </li>
                                <li class="current">
                                    <a href="{{route('font_end.course.index')}}">Courses</a>
                                </li>
                            </ul>
                        </div>

                    </nav>
                    <!-- Main Menu End-->
                </div>

                <!-- Menu Button -->
                <div class="menu-btn-sidebar d-flex align-items-center">
                    <form action="#">
                        <input type="search" placeholder="Search" required>
                        <button><i class="fas fa-search"></i></button>
                    </form>
                    <button><i class="far fa-user-circle"></i>{{Sentinel::getUser()['first_name']}}</button>
                    <a href="{{route('logout')}}" style="margin-left: 5px;"><i class="fas fa-sign-out-alt"></i></a>
                    <!-- menu sidbar -->
                    <div class="menu-sidebar">
                        <button>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Header Upper-->
</header>

<!--Form Back Drop-->
<div class="form-back-drop"></div>

<!-- Hidden Sidebar -->
<section class="hidden-bar">
    <div class="inner-box text-center">
        <div class="cross-icon"><span class="fa fa-times"></span></div>
        <div class="title">
            <h4>Get Appointment</h4>
        </div>

        <!--Appointment Form-->
        <div class="appointment-form">
            <form method="post" action="#">
                <div class="form-group">
                    <input type="text" name="text" value="" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" value="" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <textarea placeholder="Message" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="theme-btn">Submit now</button>
                </div>
            </form>
        </div>

        <!--Social Icons-->
        <div class="social-style-one">
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-pinterest-p"></i></a>
        </div>
    </div>
</section>
<!--End Hidden Sidebar -->