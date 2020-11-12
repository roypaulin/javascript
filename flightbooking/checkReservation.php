<?php
include 'functions/common.php'; 
include 'functions/reservationFunctions.php';
session_start();

if(checkTimeout()==1){
   
    echo "TIMEOUT";
    
}else{
if(isset($_POST['seat'])){
   
    
  
echo checkSeatPurchased(sanitizeString($_POST['seat']));
}
}

?>