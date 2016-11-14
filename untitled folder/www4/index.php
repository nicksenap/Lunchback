<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Lunchback Magic Onboarding</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/gsdk.css" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>

<body>

<nav class="navbar navbar-ct-azure navbar-transparent navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button id="menu-toggle" type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="#">Magic by Lunchback</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse " data-nav-image='assets/img/blog_1.png'>
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#">
                       <!-- Discover Left -->
                    </a>
                </li>
                <li>
                    <a href="#">
                        <!-- Stats Left -->
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="active">
                    <a href="#">
                        <!-- Discover -->
                    </a>
                </li>
                <li>
                    <a href="#">
                        Stats
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Settings
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-with-icons">
                        <li>
                            <a href="#">
                                <i class="pe-7s-user"></i> Account
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="pe-7s-mail"></i> Messages
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="pe-7s-portfolio"></i> Business Area
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="pe-7s-light"></i> Smart Area
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="pe-7s-tools"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-danger">
                                <i class="pe-7s-close-circle"></i>
                                Log out
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="#login-form" class="btn btn-round btn-default">Sign in</a></li>
            </ul>


        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>



<div class="wrapper">
    <div class="parallax">
        <div class="parallax-image">
            <img src="assets/img/Coffee_Mug.jpg">
        </div>
        <div class="motto">
            <div>Magic</div>
            <div class="border">sign up</div>

            <!-- <label class="pro square">PRO</label> -->
        </div>

        <h3 class="motivation">Magic will find you a match based on your goals every single week</h3>

    </div>
    <div class="section">
        <div class="container tim-container" style="max-width:800px; padding-top:100px">
            <h1 class="text-center">Right here can you login and edit your magic status<small class="subtitle">This is like a small motto before the story.</small></h1>
            <?php
            require_once('config.php');

            echo '<a href="https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id='.$config['Client_ID'].'&redirect_uri='.$config['callback_url'].'&state=98765EeFWf45A53sdfKef4233&scope=r_basicprofile r_emailaddress"><img src="./images/linkedin_connect_button.png" alt="Sign in with LinkedIn" align="middle"/></a>';
            ?>




            <!--     end extras -->
        </div>
        </div>
        <div class="space"></div>

</div> <!-- wrapper -->
</body>
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>

<!--  Plugins -->
<script src="assets/js/gsdk-checkbox.js"></script>
<script src="assets/js/gsdk-morphing.js"></script>
<script src="assets/js/gsdk-radio.js"></script>
<script src="assets/js/gsdk-bootstrapswitch.js"></script>
<script src="assets/js/bootstrap-select.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/chartist.min.js"></script>
<script src="assets/js/jquery.tagsinput.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<!-- GSDK Pro functions -->
<script src="assets/js/get-shit-done.js"></script>

<script type="text/javascript">
    $().ready(function(){
        $(window).on('scroll', gsdk.checkScrollForTransparentNavbar);
    });
</script>
<footer class="footer footer-transparent" style="background-image: url('http://37.media.tumblr.com/d77e21ed167c2125627b210b48e23f81/tumblr_na0kw25OtD1st5lhmo1_1280.jpg');">

    <!-- .footer-black is another class for the footer, for the transparent version, we recommend you to change the url of the image with your favourite image.          -->

    <div class="container">
        <nav class="pull-left">
            <ul>
                <li>
                    <a href="#">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#">
                        Company
                    </a>
                </li>
                <li>
                    <a href="#">
                        Portfolio
                    </a>
                </li>
                <li>
                    <a href="#">
                        Blog
                    </a>
                </li>
            </ul>
        </nav>
        <div class="social-area pull-right">
            <a href="#">
                <i class="fa fa-facebook-square"></i>
            </a>
            <a href="#">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="#">
                <i class="fa fa-pinterest"></i>
            </a>
        </div>
        <div class="copyright">
            &copy; 2016 Lunchback
        </div>
    </div>
</footer>
</html>





