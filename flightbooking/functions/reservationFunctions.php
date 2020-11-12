<?php




// checks if the seat has been purchased in the mean time
function checkSeat($seat){
   
    $conn=connectDB();
    $res=null;
    //echo "here";
    $query = "SELECT * FROM seat where name=?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $seat);
        if(!mysqli_stmt_execute($stmt)){
            mysqli_close($conn);
            throw new Exception("Exception  checkSeat");
        }
        mysqli_stmt_store_result($stmt);
     //echo   mysqli_stmt_num_rows($stmt);
        $res=mysqli_stmt_num_rows($stmt);
        //echo $res;
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }
    else {
        mysqli_close($conn);
        throw new Exception("Exception  checkSeat");
    }
    mysqli_close($conn);
    //echo $res;
    return $res;
    
}


// checks if the seat has been purchased in the mean time
function checkSeatPurchased($seat){
    $conn=connectDB();
    $query = "SELECT * FROM seat WHERE name=? AND status=? FOR UPDATE";
    $result = null;
    $status='purchased';
    //echo $seat;
    try{
        // Disable autocommit
        mysqli_autocommit($conn, false);
    if($stmt = mysqli_prepare($conn, $query)){
        mysqli_stmt_bind_param($stmt, "ss", $seat,$status);
        if(!mysqli_stmt_execute($stmt)){
           // mysqli_close($conn);
            throw new Exception("Exception  checkSeatPurchased");
        }
        mysqli_stmt_store_result($stmt);
        $result=mysqli_stmt_num_rows($stmt);
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        mysqli_commit($conn);
    }else {
       
        throw new Exception("Exception  checkSeatPurchased");
    }
   
    }catch(Exception $e){
        // Rollback and give back the exception message
        mysqli_rollback($conn);
        mysqli_close($conn);
       return -1;
    }
   //echo intval($result);
    mysqli_close($conn);
    if($result==1) return "PURCHASED";
    return "FREE";
    
}

function insertReservation($seat,$username){
    
    $conn=connectDB();
    //$username=$_SESSION['user'];
    //echo 'here';
    try {
        // Disable autocommit
        mysqli_autocommit($conn, false);
        
        $query = "SELECT username FROM reservation WHERE seat=? FOR UPDATE";
        if(!$stmt = mysqli_prepare($conn, $query)){
            // mysqli_close($conn);
            throw new Exception("Error in the reservation process");
        }
        mysqli_stmt_bind_param($stmt, "s", $seat);
        if(!mysqli_stmt_execute($stmt)){
            // mysqli_close($conn);
            throw new Exception("Error in the riservation process");
        }
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt)==0){
          // add a new reservation
          addReservation($conn, $username, $seat);
          
           //update seat status
           updateSeatStatus($conn, $seat,'reserved');
        }else {
            
           //update reservation
           updateReservation($conn, $username, $seat);
           
        }
        
        
        
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        // All ok commit
        mysqli_commit($conn);
    } catch (Exception $e) {
        // Rollback and give back the exception message
        mysqli_rollback($conn);
        mysqli_close($conn);
       return 0;
        
    }
    mysqli_close($conn);
    return 1;
}




function deleteReservation($seat,$user){
    $conn=connectDB();
    
    try{
        mysqli_autocommit($conn, false);
        
        $rows=atLeastOneByMe($conn, $user,$seat);
      
        //update seat status
       if($rows==1){
           //delete seat reservation
           deleteFromReservation($conn, $seat);
           
        updateSeatStatus($conn, $seat,'free');
       
       }else{
           $rows=atLeastOne($conn, $seat);
           mysqli_commit($conn);
           mysqli_close($conn);
        
          //$rows=1;
          if($rows==1)
           return "RESERVED";
          else return "PURCHASED";
       }
        
        mysqli_commit($conn);
    }catch(Exception $e){
        
        // Rollback and give back the exception message
        mysqli_rollback($conn);
        mysqli_close($conn);
        return "FAILED";
        
    }
    
    mysqli_close($conn);
    return "FREE";
    
}







function atLeastOne($conn,$seat){
    $query="SELECT * FROM reservation WHERE seat=? FOR UPDATE";
    $rows=null;
    if($stmt = mysqli_prepare($conn, $query)){
        mysqli_stmt_bind_param($stmt, "s", $seat);
        if(!mysqli_stmt_execute($stmt)){
            throw new Exception("Exception atLeastOne");
        }
        mysqli_stmt_store_result($stmt);
        $rows= mysqli_stmt_num_rows($stmt);
        //mysqli_stmt_fetch($stmt);	
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }else{
        throw new Exception("Exception atLeastOne");
    }
    return $rows;
}

function atLeastOnebyMe($conn,$user,$seat){
    $query="SELECT * FROM reservation WHERE username= ? AND seat=? FOR UPDATE";
    $rows=null;
    if($stmt = mysqli_prepare($conn, $query)){
        mysqli_stmt_bind_param($stmt, "ss", $user,$seat);
        if(!mysqli_stmt_execute($stmt)){
            throw new Exception("Exception atLeastOne");
        }
        mysqli_stmt_store_result($stmt);
        $rows= mysqli_stmt_num_rows($stmt);
       
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }else{
        throw new Exception("Exception atLeastOne");
    }
    return $rows;
}

function deleteFromReservation($conn,$seat){
    $query = "DELETE FROM reservation WHERE seat=?";
    if(!$stmt = mysqli_prepare($conn, $query)){
        throw new Exception("Error in deleting the record");
    }
    mysqli_stmt_bind_param($stmt, "s", $seat);
    if(!mysqli_stmt_execute($stmt)){
        throw new Exception("Error in deleting the record, try again");
    }
    
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_affected_rows($stmt)!=1){
        throw new Exception("Error in deleting the record, try again");
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    
}

function updateSeatStatus($conn,$seat,$status){
    
    $query = "UPDATE seat SET status=? WHERE name=?";
    if(!$stmt = mysqli_prepare($conn, $query)){
        throw new Exception("Error in the reservation process");
    }
 
    mysqli_stmt_bind_param($stmt, "ss",$status, $seat);
    if(!mysqli_stmt_execute($stmt)){
        throw new Exception("Error in the riservation process");
    }
    if(mysqli_stmt_affected_rows($stmt)!=1){
        
        throw new Exception("Error in updating the seat status");
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    
}

function updateReservation($conn,$username,$seat){
    $query = "UPDATE reservation SET username=? WHERE seat=?";
    if(!$stmt = mysqli_prepare($conn, $query)){
        throw new Exception("Error in the reservation process");
    }
    mysqli_stmt_bind_param($stmt, "ss",$username, $seat);
    if(!mysqli_stmt_execute($stmt)){
        // mysqli_close($conn);
        throw new Exception("Error in the riservation process");
    }
    if(mysqli_stmt_affected_rows($stmt)!=1){
        // mysqli_close($conn);
        throw new Exception("Error in updating the reservation");
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
}

function addReservation($conn,$username,$seat){
    
 
    $query = "INSERT INTO reservation(username,seat) VALUES (?,?)";
    if(!$stmt = mysqli_prepare($conn, $query)){
        // mysqli_close($conn);
        throw new Exception("Error in the reservation process");
    }
    mysqli_stmt_bind_param($stmt, "ss",$username, $seat);
    if(!mysqli_stmt_execute($stmt)){
        //mysqli_close($conn);
        throw new Exception("Error in the riservation process");
    }
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_affected_rows($stmt)!=1){
        // mysqli_close($conn);
        throw new Exception("Error in inserting the new reservation");
    }
    
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
}
?>