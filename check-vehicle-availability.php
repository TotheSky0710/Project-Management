<?php 
require_once("includes/config.php");
// code user email availablity
if(!empty($_GET["vhid"])) {
	$vhid= $_GET["vhid"];
	
	$sql ="SELECT vehicleid FROM tbooking WHERE tblvehicles.id=:vhid ";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':vehicleid', $vhid, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    $cnt=1;
    if($query -> rowCount() > 14){
        echo "<span style='color:red'> Lender already exists .</span>";
        echo "<script>$('#submit').prop('disabled',true);</script>";
    }else{
        echo "<span style='color:green'> Lender available for Registration .</span>";
        echo "<script>$('#submit').prop('disabled',false);</script>";
    }
}



?>
