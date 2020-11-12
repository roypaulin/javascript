<?php
include 'functions/common.php';
include 'functions/reservationFunctions.php';
session_start();

if(checkTimeout()==1){
    echo "TIMEOUT";
}else{
if(isset($_POST['seat'])){
    
    
    echo deleteReservation(sanitizeString($_POST['seat']),sanitizeString($_SESSION['user']));
}
}
?>