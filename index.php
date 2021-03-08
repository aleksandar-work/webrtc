<?php
session_start();

include_once 'server/connect.php';

$actual_link = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Class</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!-- Icon -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">
    <!-- Slicknav -->
    <link rel="stylesheet" type="text/css" href="assets/css/slicknav.css">
    <!-- Nivo Lightbox -->
    <link rel="stylesheet" type="text/css" href="assets/css/nivo-lightbox.css">
    <!-- Animate -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

</head>
<body>

<!-- Header Area wrapper Starts -->
<header id="header-wrap">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
                        aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="icon-menu"></span>
                    <span class="icon-menu"></span>
                    <span class="icon-menu"></span>
                </button>
                <a href="#" class="navbar-brand"><img src="assets/img/logo.png" alt=""></a>
            </div>
            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    <li class="nav-item active">
                        <a class="nav-link" href="#header-wrap">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#doctors">
                            Doctors
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link btn btn-border" href="/dash">
                            I am a doctor
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Menu Start -->
        <ul class="mobile-menu">
            <li>
                <a class="page-scrool" href="#header-wrap">Home</a>
            </li>

            <li>
                <a class="page-scroll" href="#doctors">Doctors</a>
            </li>

            <li class="nav-item">
                <a class="nav-link btn btn-border" href="/dash">
                    I am a doctor
                </a>
            </li>
        </ul>
        <!-- Mobile Menu End -->

    </nav>
    <!-- Navbar End -->

    <!-- Main Carousel Section Start -->
    <div id="main-slide" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#main-slide" data-slide-to="0" class="active"></li>
            <li data-target="#main-slide" data-slide-to="1"></li>
            <li data-target="#main-slide" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="assets/img/slider/slide1.jpg" alt="First slide">

                <div class="carousel-caption d-md-block">
                    <p class="fadeInUp wow" data-wow-delay=".6s">Famous doctor registered in Israel.</p>

                    <h1 class="wow fadeInDown heading" data-wow-delay=".4s">To keep your body in good health is our
                        duty.</h1>
                    <a href="#" class="fadeInLeft wow btn btn-common btn-lg" data-wow-delay=".6s">Get Class</a>
                    <a href="#" class="fadeInRight wow btn btn-border btn-lg" data-wow-delay=".6s">Explore More</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/img/slider/slide2.jpg" alt="Second slide">

                <div class="carousel-caption d-md-block">
                    <p class="fadeInUp wow" data-wow-delay=".6s">Perfect happiness is healthy family.</p>

                    <h1 class="wow bounceIn heading" data-wow-delay=".7s">You learn good health and family are it, and
                        nothing else matters.</h1>
                    <a href="#" class="fadeInUp wow btn btn-border btn-lg" data-wow-delay=".8s">Learn More</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/img/slider/slide3.jpg" alt="Third slide">

                <div class="carousel-caption d-md-block">
                    <p class="fadeInUp wow" data-wow-delay=".6s">Doctors everywhere.</p>

                    <h1 class="wow fadeInUp heading" data-wow-delay=".6s">Speak to a doctor securely on the app,
                        medication delivered to you.</h1>
                    <a href="#" class="fadeInUp wow btn btn-common btn-lg" data-wow-delay=".8s">Explore</a>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#main-slide" role="button" data-slide="prev">
            <span class="carousel-control" aria-hidden="true"><i class="lni-chevron-left"></i></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#main-slide" role="button" data-slide="next">
            <span class="carousel-control" aria-hidden="true"><i class="lni-chevron-right"></i></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- Main Carousel Section End -->

</header>
<!-- Header Area wrapper End -->


<!-- Blog Section Start -->
<section id="doctors" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12" id="doctor_title">
                <div class="section-title-header text-center">
                    <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">Our Online Doctors</h1>

                    <p class="wow fadeInDown" data-wow-delay="0.2s">Global Online Medical Consultants</p>
                </div>
            </div>

            <!--          <div class="col-12 text-center">-->
            <!--            <a href="#" class="btn btn-common">View More Doctors</a>-->
            <!--          </div>-->
        </div>
    </div>
</section>
<!-- Blog Section End -->


<!-- Counter Area Start-->
<section class="counter-section section-padding">
    <div class="container">
        <div class="row">
            <!-- Counter Item -->
            <div class="col-md-6 col-lg-3 col-xs-12 work-counter-widget text-center">
                <div class="counter wow fadeInRight" data-wow-delay="0.3s">
                    <div class="icon"><i class="lni-map"></i></div>
                    <p>Great Nation</p>
                    <span>Tel Aviv, Israel</span>
                </div>
            </div>
            <!-- Counter Item -->
            <div class="col-md-6 col-lg-3 col-xs-12 work-counter-widget text-center">
                <div class="counter wow fadeInRight" data-wow-delay="0.6s">
                    <div class="icon"><i class="lni-timer"></i></div>
                    <p>Instant Help</p>
                    <span>No time loss</span>
                </div>
            </div>
            <!-- Counter Item -->
            <div class="col-md-6 col-lg-3 col-xs-12 work-counter-widget text-center">
                <div class="counter wow fadeInRight" data-wow-delay="0.9s">
                    <div class="icon"><i class="lni-users"></i></div>
                    <p>Unlimited doctors</p>
                    <span>Always available</span>
                </div>
            </div>
            <!-- Counter Item -->
            <div class="col-md-6 col-lg-3 col-xs-12 work-counter-widget text-center">
                <div class="counter wow fadeInRight" data-wow-delay="1.2s">
                    <div class="icon"><i class="lni-coffee-cup"></i></div>
                    <p>Always with snacks</p>
                    <span>Very comfortable</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Counter Area End-->


<!-- Class Slides Section Start -->
<section id="class-slides" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title-header text-center">
                    <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">Dandash Guideline</h1>

                    <p class="wow fadeInDown" data-wow-delay="0.2s">Global Online Medical Consultants</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-12 wow fadeInRight" data-wow-delay="0.3s">
                <div class="video">
                    <img class="img-fluid" src="assets/img/about/guide.jpg" alt="">
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-12 wow fadeInLeft" data-wow-delay="0.3s">
                <p class="intro-desc">Dandash is a online medical consultant platform using webrtc technology.Clients
                    and Doctors
                    can share screens, do video call and live chat.
                    It supports recording features and responsive interface.Also supports multi-platform.
                    Google Chrome, Safari, Firefox, Microsoft Edge. Desktop, Laptop, Mobile etc.
                </p>

                <h2 class="intro-title">Check Guide</h2>
                <ul class="list-specification">
                    <li><i class="lni-check-mark-circle"></i>If you are a client, find a doctor you want to meet.
                    </li>
                    <li><i class="lni-check-mark-circle"></i> Wait till the doctor accept your offer.</li>
                    <li><i class="lni-check-mark-circle"></i> Or write a message via email.</li>
                    <li><i class="lni-check-mark-circle"></i> If you are a doctor, click "I am a doctor" button</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Class Slides Section End -->

<div id="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-info">
                    <p>© LearnBoard 2020</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Go to Top Link -->
<a href="#" class="back-to-top">
    <i class="lni-chevron-up"></i>
</a>


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/jquery-min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.countdown.min.js"></script>
<script src="assets/js/jquery.nav.js"></script>
<script src="assets/js/jquery.easing.min.js"></script>
<script src="assets/js/wow.js"></script>
<script src="assets/js/jquery.slicknav.js"></script>
<script src="assets/js/nivo-lightbox.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/form-validator.min.js"></script>
<script>

    function myFunc() {

        $('#newdev_widget_msg').click();
    }

    //     jQuery(document).ready(function ($) {
    //         $.ajax({
    //                 type: 'POST',
    //                 url: 'server/script.php',
    //                 data: {'type': 'getrooms','agentId': 'admin'}
    //             })
    //             .done(function (data) {
    // //              alert('ok');
    //                 if (data) {
    //                     var result = JSON.parse(data);
    //                     console.log(result);
    //                     var getCurrentDateFormatted = function (date) {
    //                         var currentdate = new Date(date);
    //                         if (currentdate.getDate()) {
    //                             return ('0' + currentdate.getDate()).slice(-2) + "/"
    //                                 + ('0' + (currentdate.getMonth() + 1)).slice(-2) + "/"
    //                                 + currentdate.getFullYear() + " "
    //                                 + ('0' + currentdate.getHours()).slice(-2) + '.' + ('0' + currentdate.getMinutes()).slice(-2);
    //                         } else {
    //                             return '';
    //                         }
    //                     };
    //
    //
    //                     $.each(result, function (i, item) {
    //
    //                         var html = '<div class="col-lg-4 col-md-6 col-xs-12">' +
    //                             '<div class="blog-item">' +
    //                             '<div class="blog-image">' +
    //                             '<a target="_blank" title="Consult with this doctor." href="request.php?room_id='+item.room_id+ '">' +
    //                             '<img class="img-fluid" src="assets/img/blog/img.jpg" alt="">' +
    //                             '</a>' +
    //                             '</div>' +
    //                             '<div class="descr">' +
    //                             '<div class="tag">' + item.roomId + '</div>' +
    //                             '<h3 class="title">' +
    //
    //                             item.agent +
    //
    //                             '</h3>' +
    //                             '<div class="meta-tags">' +
    //                             '<span class="date"> ' + item.datetime.substr(0, 10) + '</span>' +
    //                             '<span class="comments">| <a> by ' + item.agent_id + '</a></span>' +
    //                             '</div><div style="text-align-last: center;" class="nd-widget-container">' +
    //                             '<div  style="z-index: 99" class="newdev_widget_div">' +
    //                             '</div>' +
    //                             '</div></div>' +
    //                             '</div></div>';
    //                         $('#doctor_title').after(html);
    //
    //                     });
    //
    //
    //                 }
    //             })
    //             .fail(function () {
    //                 console.log(false);
    //             });
    //
    //     });
    //


    jQuery(document).ready(function ($) {
        $.ajax({
            type: 'POST',
            url: 'server/script.php',
            data: {'type': 'getrooms'}
        })
            .done(function (data) {
//              alert('ok');
                if (data) {
                    var result = JSON.parse(data);
                    console.log(result);
                    var getCurrentDateFormatted = function (date) {
                        var currentdate = new Date(date);
                        if (currentdate.getDate()) {
                            return ('0' + currentdate.getDate()).slice(-2) + "/"
                                + ('0' + (currentdate.getMonth() + 1)).slice(-2) + "/"
                                + currentdate.getFullYear() + " "
                                + ('0' + currentdate.getHours()).slice(-2) + '.' + ('0' + currentdate.getMinutes()).slice(-2);
                        } else {
                            return '';
                        }
                    };


                    $.each(result, function (i, item) {

                        var html = '<div class="col-lg-4 col-md-6 col-xs-12">' +
                            '<div class="blog-item">' +
                            '<div class="blog-image">' +
                            '<a target="_blank" title="Consult with this doctor." href="request.php?room_id='+item.room_id+ '">' +
                            '<img class="img-fluid" src="assets/img/blog/img.jpg" alt="">' +
                            '</a>' +
                            '</div>' +
                            '<div class="descr">' +
                            '<div class="tag">' + item.roomId + '</div>' +
                            '<h3 class="title">' +

                            item.agent +

                            '</h3>' +
                            '<div class="meta-tags">' +
                            '<span class="date"> ' + item.datetime.substr(0, 10) + '</span>' +
                            '<span class="comments">| <a> by ' + item.agent_id + '</a></span>' +
                            '</div><div style="text-align-last: center;" class="nd-widget-container">' +
                            '<div  style="z-index: 99" class="newdev_widget_div">' +
                            '<button class="widget-but trn-link" title="" onclick="myFunc()"><span' +
                            'class="icon-bnt"></span><span class="newdev_widget_msg" >Request Live Chat</span><span  class="offline-bnt"></span>' +

                            '</button>' +
                            '</div>' +
                            '</div></div>' +
                            '</div></div>';
                        $('#doctor_title').after(html);

                    });

                }
            })
            .fail(function () {
                console.log(false);
            });

    });

</script>
<div id="nd-widget-container" class="nd-widget-container"></div>
<script id="newdev-embed-script" data-message="Start Video Chat" data-source_path="https://localhost/" src="js/widget.js" data-button-css="button_gray.css" data-avatar="../img/avatar.png" data-names="John Doe" async></script>
</body>
</html>
