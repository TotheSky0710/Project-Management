<?php 
session_start();
include('includes/config.php');
error_reporting(0);

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>SPDS</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">



<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/bus.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/bus.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/bus.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/bus.png">
<link rel="stylesheet" href="assets/css/map.css">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 
<link rel="stylesheet" href="assets/css/modal_confirmation.css">
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script src="onesignal.js"></script>
</head>
<body>





<!--Header--> 
<?php include('includes/header.php');?>
<!-- /Header --> 


<!--Mobile Checker-->
<?php
$mobile = false;
    $banner = 'banner-section';
    if ($detect->isMobile() || $detect->isTablet() ) {
        $mobile = true;
    $banner = 'mobile-banner-section';
    }
?>
<!--/Mobile Checker-->

<!-- GET TAGS -->
<?php

if(isset($_SESSION['login'])) {
  $sql = "SELECT id, UserType FROM tblusers WHERE EmailId=:user_email";
  $query = $dbh->prepare($sql);
  $query->bindParam(':user_email', $_SESSION['login'], PDO::PARAM_STR);
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_OBJ);
?>

<?php
}
?>

<!--Page Header-->
<section id="banner" >
  <div class="container">
    <div class="div_zindex">
      <div class="row">
        <div class="col-md-5 col-md-push-7">
          <div class="banner_content">
            <h1 class="" style="color: #000000;">ALL YOUR SCHOOL TRANSPORT NEEDS </h1>
            <p class="" style="color: #000000;"><small>Student Pick and drop system help you choose a preffered mode and booking it instantly.</small></p>
            
                  
        </div>z
      </div>
    </div>
  </div>
</section>
<!-- /Page Header--> 



<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<!-- Scripts --> 

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<!--Switcher-->

<!--bootstrap-slider-JS-->
<script src="assets/js/bootstrap-slider.min.js"></script>
<!--Slider-JS-->
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</script>
</html>
