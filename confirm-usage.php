<?php
session_start();


    include('includes/config.php');

   
    require 'vendor/autoload.php';
    use Twilio\Rest\Client;

            
       
    $booking_id = $_POST['booking_id'];
   

    $sql = "UPDATE tblusage SET confirmation = 1 WHERE booking_id = :booking_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':booking_id', $booking_id, PDO::PARAM_STR);
    $query->execute();

    
    
    echo "Booking ID #" . $booking_id . " usage has successfully started.";


    $key = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    $code = "";
    $id= $booking_id;
    for($i = 0; $i < 5; ++$i)
        $code .= $key[rand(0,strlen($key) - 1)];
   
        $bookingi_id = $code.$id;
        

  
    
?>