<?php 
session_start();
include('includes/config.php');
$user=$_SESSION['fname'];
error_reporting(0);
if(isset($_POST['submit']))
{
$fromdate=$_POST['fromdate'];
$todate=$_POST['todate']; 
$message=$_POST['message'];
$useremail=$_SESSION['login'];
$status=0;
$vhid=$_GET['vhid'];



//Check for duplicate schedules
$checksql = "SELECT id FROM tblbooking WHERE FromDate = :from  AND ToDate= :to AND (vehicleid=:vhid) ";
$query= $dbh -> prepare($checksql);
$query->bindParam(':from', $fromdate, PDO::PARAM_STR);
$query->bindParam(':to', $todate, PDO::PARAM_STR);
$query->bindParam(':vhid',$vhid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 14) {
    echo "<script>alert('vehicle is full  please choose another vehicle.');</script>";
}
else {

if ($todate < $fromdate) {
     echo "<script>alert('Booking schedule is invalid. Please choose a sensible date.');</script>";
    return;
}


$sql="INSERT INTO  tblbooking(userEmail,VehicleId,FromDate,ToDate,message,Status) VALUES(:useremail,:vhid,:fromdate,:todate,:message,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':vhid',$vhid,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['renter_notification_message'] = 'A renter has booked one of your vehicle';
include('includes/one-signal.php');
// include('includes/create-notif.php');
echo "<script>alert('Booking successful.');</script>";
?>
<?php
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}

}

?>


<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>SPDS | Vehicle Details</title>
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

<!-- SWITCHER -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/bus.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/bus.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/bus.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/bus.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 

</head>
<body>
<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Listing-Image-Slider-->

<?php 
$vhid=intval($_GET['vhid']);
$sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:vhid";
$query = $dbh -> prepare($sql);
$query->bindParam(':vhid',$vhid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
    $_SESSION['lenderid'] = $results[0]->user_id;
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  

$_SESSION['brndid']=$result->bid;  
?>  

<section id="listing_img_slider">
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive"  alt="image" width="900" height="560"></div>
  <?php if($result->Vimage5=="")
{

} else {
  ?>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
</section>
<!--/Listing-Image-Slider-->


<?php }} ?>

<div class="container" style="border: 1px solid #d0d3d4; width: 100%; padding: 10px 15px;">
  <p style="font-size: 20px;"><i class="fa fa-info-circle" style="color:gray;"></i><strong>&nbsp;Other Details</strong></p>
  <?php
    $sql = "SELECT user.Fullname, user.EmailId FROM tblusers user INNER JOIN tblvehicles vehicle ON user.id = vehicle.user_id WHERE vehicle.id = :vehicle_id;";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':vehicle_id', $_REQUEST['vhid'], PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
  ?>
  <table class="table table-striped">
  <tr>
    <th>drivers 's Name</th>
    <td><?php echo $result[0]->Fullname; ?> <span class="fa fa-check-circle" style="color: green; font-size: 20px; padding-bottom: 0;"></span></td>
  </tr>
  <tr>
    <th>driver's Email Address</th>
    <td><?php echo $result[0]->EmailId; ?></td>
  </tr>
  <tr>
    <th>Vehicle's Overall Customer Ratings</th>
    <?php
      $sql = "SELECT (SUM(ratings.rating)/COUNT(ratings.rating)) as average FROM tblratings ratings INNER JOIN tblbooking booking ON ratings.booking_Id = booking.id INNER JOIN tblvehicles vehicle ON booking.VehicleId = vehicle.id WHERE vehicle.id = :vehicle_id AND ratings.type = 1;";
      $query = $dbh->prepare($sql);
      $query -> bindParam(':vehicle_id', $_REQUEST['vhid'], PDO::PARAM_STR);
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_OBJ);
    ?>
    <td><?php echo number_format($result[0]->average, 1); ?></td>
  </tr>
  </table>
</div>

      </div>


      <!-- reveiw  page -->

      <section >
      <div class="col-md-8 col-sm-8">
        <div class="profile_wrap">
          <h5 class="uppercase"> Car Reviews </h5>
          <div class="my_vehicles_list">
            <ul class="vehicle_listing">
<?php 

$vhid=intval($_GET['vhid']);
$sql = "SELECT * from tbltestimonial where vehicleid=:vhid";
$query = $dbh -> prepare($sql);
$query->bindParam(':vhid',$vhid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($cnt=$query->rowCount() > 0)
{
foreach($results as $result)
{ ?>

              <li>
           
                <div class="">
                 <p><?php echo htmlentities($result->Testimonial);?> </p>
                   <p><b>Posting Date:</b><?php echo htmlentities($result->PostingDate);?> </p>
                
                  </div>
                <?php if($result->status==1){ ?>

                  <div class="clearfix"></div>
                  </div>
                  <?php } else {?>
               <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Waiting for approval</a>
                  <div class="clearfix"></div>
                  </div>
                  <?php } ?>
              </li>
              <?php } } ?>
              
            </ul>
           
          </div>
        </div>
      
        </section>
      
      
      <!--Side-Bar-->
     
      <aside class="col-md-3">
        
        
                <?php if ($_SESSION['utype'] == '1')  { ?>
        
        <?php
          $sql = "SELECT userEmail, VehicleId, FromDate, ToDate, Status FROM tblbooking WHERE userEmail = :email and VehicleId = :vehicle_id and ((FromDate > CURDATE() and ToDate > CURDATE() and Status = 1) or (Status = 1 or Status = 0)) order by id desc limit 1";
          $query = $dbh->prepare($sql);
          $query->bindParam(':email',$_SESSION['login'],PDO::PARAM_STR);
          $query->bindParam(':vehicle_id',$_GET['vhid'],PDO::PARAM_STR);
          $query->execute();
          $results = $query->rowCount();
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          
          if ($results == 0) {
           
            ?>
            <div class="sidebar_widget">
            <div class="widget_heading">
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>Book  now   </h5>
            <h5>Note :Booking is done monthly  </h5>
          </div>
          <form method="post">
            <div class="form-group">
              <input type="date" min="<?php print strftime('%F'); ?>" class="form-control" name="fromdate" placeholder="From Date(dd/mm/yyyy)" required>
            </div>
            <div class="form-group">
              <input type="date" min="<?php print strftime('%F'); ?>" class="form-control" name="todate" placeholder="To Date(dd/mm/yyyy)" required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="message" placeholder="specify pick up and drop location and prefferred  pickup time" required></textarea>
            </div>
          <?php if($_SESSION['login'])
              {?>
              <div class="form-group">
                <input type="submit" class="btn"  name="submit" value="BOOK ">
              </div>
              <?php } else { ?>
              <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login to Rent</a>

              <?php } ?>
          </form>
        </div>
            <?php
          }else{
          
           if ($fetch[0]->Status == 0) {
              ?>
              <p>Booking  will be confirmed if prescence is confirmed by driver  check  my bookings for more info</p>
              <?php
            }else{
              ?>
              <p>complete booking by paying the driver  check my bookings for more  info</p>
              <?php
            }
          }
        ?>
               <?php }  ?>
      </aside>
      <!--/Side-Bar--> 




      <!-- review submission -->
    </div>
    <div class="col-md-6 col-sm-8">
        <div class="profile_wrap">
          <h5 class=""> post a review</h5>
            <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
          <form  method="post">
          
       <?php   
if(isset($_POST['submit-testimonial']))
  {
$testimonoial=$_POST['testimonial'];
$email=$_SESSION['login'];
$status=1;
$vhid=$_GET['vhid'];
$sql="INSERT INTO  tbltestimonial(UserEmail,Testimonial,VehicleId,Status) VALUES(:email,:testimonoial,:vhid,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':testimonoial',$testimonoial,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':vhid',$vhid,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
  
echo "<script>alert('review succesfully submitted.');</script>";
}
else 
{
  
echo "<script>alert('Something went wrong. Please try again');</script>";
}

}
?>
            <div class="form-group">
              <!-- <label class="control-label">Reviews</label> -->
              <textarea class="form-control white_bg" name="testimonial" rows="4" required=""></textarea>
            </div>
          
           
            <div class="form-group">
              <button type="submit" name="submit-testimonial" class="btn">Save  <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </div>
          </form>
        </div>
      </div>
    
    <div class="space-20"></div>
    <div class="divider"></div>
    
    
  </div>
</section>
<!--/Listing-detail--> 

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

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>

</html>