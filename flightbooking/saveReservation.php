<?php
include 'functions/common.php';
include 'functions/reservationFunctions.php';
session_start();
if(isset($_SESSION['user'])){
    if(isset($_POST['seat']) ){
    
       
   echo insertReservation(sanitizeString($_POST['seat']),sanitizeString($_SESSION['user']));
}
}
?>