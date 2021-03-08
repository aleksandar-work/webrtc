<?php
session_start();

include_once 'server/connect.php';

$actual_link = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$room_id = $_GET['room_id'];

global $dbPrefix, $pdo;


    $array = [$room_id];
    $stmt = $pdo->prepare("SELECT * FROM " . $dbPrefix . "agents a," . $dbPrefix . "rooms r WHERE r.room_id= ? AND r.is_active = 1 and r.agent_id=a.tenant");
    $stmt->execute($array);
    $room = $stmt->fetch();
//var_dump($room);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Client</title>

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
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
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


            <li class="nav-item">
                <a class="nav-link btn btn-border" href="/dash">
                    I am a doctor
                </a>
            </li>
        </ul>
        <!-- Mobile Menu End -->

    </nav>
    <!-- Navbar End -->

</header>

<section id="pricing" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title-header text-center">
                    <h1 class="section-title wow fadeInUp animated" data-wow-delay="0.2s" style="visibility: visible;-webkit-animation-delay: 0.2s; -moz-animation-delay: 0.2s; animation-delay: 0.2s;">Please Consult with Doctor</h1>

                </div>
            </div>
        </div>
        <div class="row">
            <div id="doctor_detail" class="col-lg-4 col-sm-6 col-xa-12 mb-3">
                <div class="price-block-wrapper wow fadeInLeft animated" data-wow-delay="0.2s" style="visibility: visible;-webkit-animation-delay: 0.2s; -moz-animation-delay: 0.2s; animation-delay: 0.2s;">
                    <div class="icon">
                        <i class="lni-write"></i>
                    </div>
                    <div class="colmun-title">
                        <h5>Registered</h5>
                    </div>
                    <div class="price">
                        <h2>$100</h2>
                        <p>you are welcome!</p>
                    </div>
                    <div class="pricing-list">
                        <ul>
                            <li><span class="text">First Name: <?php echo $room['first_name'] ?></span></li>
                            <li><span class="text">Last Name: <?php echo $room['last_name'] ?></span></li>
                            <li><span class="text">Email: <?php echo $room['email'] ?></span></li>
                            <li><span class="text">Phone: 1234567890</span></li>
                            <li><a target="_blank" href="<?php echo $room['visitorurl'] ?>"><span class="text">Enter room</span></a></li>
                        </ul>
                    </div>


                </div>
            </div>
            <div class="col-lg-8 col-sm-6 col-xa-12 mb-3">
                <div class="price-block-wrapper wow fadeInUp animated" data-wow-delay="0.3s" style="visibility: visible;-webkit-animation-delay: 0.3s; -moz-animation-delay: 0.3s; animation-delay: 0.3s;">

                <iframe id="video" style="width: 100%;"></iframe>
                </div>
            </div>

        </div>

    </div>
</section>
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
    // Selecting the iframe element
    var iframe = document.getElementById("video");
    var doctor_detail = document.getElementById('doctor_detail');

    // Adjusting the iframe height onload event
        iframe.style.height = (doctor_detail.scrollHeight-40)+ 'px';

</script>
<div id="nd-widget-container" class="nd-widget-container"></div>
<script id="newdev-embed-script" data-message="Consult" data-iframe_id="video" data-offline_email="<?php echo $room['email'] ?>" data-agent_id="<?php echo $room['agent_id']; ?>" data-source_path="https://localhost/" src="js/widget.js" data-button-css="button_gray.css" data-avatar="../img/avatar.png" data-names="John Doe" async></script>

</body>
</html>