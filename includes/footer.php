<?php
if(isset($_POST['emailsubscibe']))
{
$subscriberemail=$_POST['subscriberemail'];
$sql ="SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
$query= $dbh -> prepare($sql);
$query-> bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<script>alert('Already Subscribed.');</script>";
}
else{
$sql="INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
$query = $dbh->prepare($sql);
$query->bindParam(':subscriberemail',$subscriberemail,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Subscribed successfully.');</script>";
}
else
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}
}
?>


<?php 
if( !$detect->isMobile() && !$detect->isTablet() ){
    echo '
<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">';
        
        if (!$detect->isMobile() && !$detect->isTablet()) { include('subscribe.php'); }
    
        echo '</div>
        <div class="col-md-3 col-md-6">
          <h6>QUICK LINKS</h6>
          <ul>
          <li><a href="car-listing.php">Book-now</a></li>
            <li><a href="contact-us.php">Contact us</a></li>
            <li><a href="admin/">Admin Login</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
        </div>
      </div>
    </div>
  </div>
</footer>

';


} 
  ?>
  
  <script>

    $("img").on("error", function () {
    $(this).attr("src", "../img/error.png");
});
</script>
  
  
  

