<?php

require("config.php");
$submitted_username = '';
if(!empty($_POST)){
    $query = " 
            SELECT 
                external_id as password
            FROM lunchback_user_profiles 
            WHERE 
                email = :username 
        ";
    $query_params = array(
        ':username' => $_POST['username']
    );

    try{
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
    $login_ok = false;
    $row = $stmt->fetch();
    if($row){
        /*$check_password = hash('sha256', $_POST['password'] . $row['salt']);
        for($round = 0; $round < 65536; $round++){
            $check_password = hash('sha256', $check_password . $row['salt']);
        }*/
        $check_password = $_POST['password'];
        if($check_password === $row['password']){
            $login_ok = true;
        }
    }

    if($login_ok){
        unset($row['password']);
        $_SESSION['user'] = $row;
        header("Location: dashboard.php");
        die("Redirecting to: dashboard.php");
    }
    else{
        print("Login Failed.");
        $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
    }
}

?>

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

            <div class="login-form-1">
                <form id="login-form" class="text-left" method="post">
                    <div class="login-form-main-message"></div>
                    <div class="main-login-form">
                        <div class="login-group">
                            <div class="form-group">
                                <label for="lg_username" class="sr-only">Username</label>
                                <input type="text" class="form-control" id="lg_username" name="username" placeholder="Enter your username" value="<?php echo $submitted_username; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lg_password" class="sr-only">Password</label>
                                <input type="password" class="form-control" id="lg_password" name="password" placeholder="Enter password" value=="">
                            </div>
                            <div class="form-group login-group-checkbox">
                                <input type="checkbox" id="lg_remember" name="lg_remember">
                                <label for="lg_remember">remember</label>
                            </div>
                        </div>
                        <button type="submit" class="login-button btn btn-round btn-default" value="Login">Enter</button>
                    </div>
                    <div class="etc-login-form">
                        <p>forgot your password? <a href="#">click here</a></p>
                    </div>
                </form>
            </div>
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





