<?php
include 'functions/common.php';
include 'functions/homeFunctions.php';
session_start();

if(checkTimeout()==1){
    echo "TIMEOUT";
}else{
    if(isset($_SESSION['user']) &&  isset($_POST['num']) && is_numeric($_POST['num']) ){
        $num=$_POST['num'];
        
   // if(isNaN)
    echo purchaseSeat(sanitizeString($_SESSION['user']),$num);
    }
}
?>