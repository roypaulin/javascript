<?php // HOME FUNCTIONS





function getTableAndSeatDetails($rows,$columns){
    $conn=connectDB();
    $result=array();
    
    try{
        // Disable autocommit
        mysqli_autocommit($conn, false);
        
        //get seats info from db
        $result=getList($conn);
        
        // Fill the table 
        fillTable($conn,$result,$rows,$columns);
        
        // All ok commit
        mysqli_commit($conn);
    }catch (Exception $e) {
        // Rollback and give back the exception message
        mysqli_rollback($conn);
        mysqli_close($conn);
        redirect("error.php");
    }
    mysqli_close($conn);
   
    
}

function purchaseSeat($user,$num){
    $conn=connectDB();
    $cond=null;
    $status=null;
    try{
        
        // Disable autocommit
        mysqli_autocommit($conn, false);
        
        //check whether there is at least one reserved seat and get them
        $cond=atLeastOne($conn,$user);
        if($cond>0){
           // $seats=getSeats($conn,$user);
           
            if($cond==$num){
                $status='purchased';
            updateStatus($conn,$user,$cond,$status);
            deleteReservations($conn, $user, $cond);
           
            }else{
                $status='free';
                updateStatus($conn,$user,$cond,$status);
                deleteReservations($conn, $user, $cond);
                
                mysqli_commit($conn);
                mysqli_close($conn);
                return "PURCHASED";
            }
        }else {
            mysqli_commit($conn);
            mysqli_close($conn);
            return "NONE";
        }
        
        // All ok commit
        mysqli_commit($conn);
    }catch(Exception $e){
        // Rollback and give back the exception message
        mysqli_rollback($conn);
        $status='free';
        updateStatus($conn,$user,$cond,$status);
        deleteReservations($conn, $user, $cond);
       
        mysqli_close($conn);
        return "ERROR";
    }
    
    mysqli_close($conn);
    return "SUCCESS";
}





function deleteReservations($conn,$user,$rows){
    $query = "DELETE FROM reservation WHERE username=?";
    if(!$stmt = mysqli_prepare($conn, $query)){
        throw new Exception("Error in deleting the record");
    }
    mysqli_stmt_bind_param($stmt, "s", $user);
    if(!mysqli_stmt_execute($stmt)){
        throw new Exception("Error in deleting the record");
    }
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_affected_rows($stmt)!=$rows){
        throw new Exception("Error in deleting the record");
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    
}

function updateStatus($conn,$user,$rows,$status){
    $query="UPDATE seat SET status=? WHERE name IN ( SELECT seat FROM reservation WHERE username=?)";
    if(!$stmt = mysqli_prepare($conn, $query)){
        throw new Exception("Error in the purchase process");
    }
   // $status='purchased';
    mysqli_stmt_bind_param($stmt, "ss",$status, $user);
    if(!mysqli_stmt_execute($stmt)){
       
        throw new Exception("Error in the purchase process");
    }
    if(mysqli_stmt_affected_rows($stmt)!=$rows){
        // mysqli_close($conn);
        throw new Exception("Error in purchase the reservation");
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    
}


function atLeastOne($conn,$user){
    $query="SELECT * FROM reservation WHERE username=? FOR UPDATE";
    $rows=null;
    if($stmt = mysqli_prepare($conn, $query)){
        mysqli_stmt_bind_param($stmt, "s", $user);
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
function whoHasReserved($conn,$seat){
    $query="SELECT username FROM reservation WHERE seat=? FOR UPDATE";
    $name=array();
    //echo $seat;
        if($stmt = mysqli_prepare($conn, $query)){
            mysqli_stmt_bind_param($stmt, "s", $seat);
            if(!mysqli_stmt_execute($stmt)){
                throw new Exception("Exception whoHasReserved");
            }
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_num_rows($stmt);
            //echo $rows;
          
            mysqli_stmt_bind_result($stmt, $name['username']);
            //if($val) echo $seat;
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
           
        }else{
            throw new Exception("Exception whoHasReserved");
        }
       // echo $name['username'];
        return $name['username'];
    
}
function printSeatDetails($freeNum,$reservedNum,$purchasedNum){
    
    echo "<p>Number of free seats: ".$freeNum."</p>";
    echo "<p>Number of reserved seats: ".$reservedNum."</p>";
    echo "<p>Number of purchased seats: ".$purchasedNum."</p>";
    
}




function fillTable($conn, $result,$rows,$columns){
   
    $freeNum=0;
    $reservedNum=0;
    $purchasedNum=0;
    
    $k=0;
    echo "<table id='table'>";
    for($i=0; $i<$rows; $i++){		
        echo "<tr>";
        for($j=0; $j<$columns; $j++){
            $status=$result[$k][2];
            if($status=='free') $freeNum++;
            if($status=='reserved') $reservedNum++;
            if($status=='purchased') $purchasedNum++;
            
            $seat=$result[$k][0];
            $num=$result[$k][1];
            
               $loggedIn=false;
                if(isset($_SESSION['user'])){
                 
                    $loggedIn=true;
            if($status=='reserved'){
            $username= whoHasReserved($conn,$seat);
            //echo "LEGRANDPASTY";
           // echo $username;
            if($username==$_SESSION['user']){
                    $status='reservedByMe';
                   
            }
            }
            }
            
            echo "<td class=$status value=$seat  id=$num islog=$loggedIn >".htmlentities($seat)."</td>";
            $k++;
        }
        echo "</tr>";
    }
    echo "</table>";
    
    printSeatDetails($freeNum,$reservedNum,$purchasedNum);
}








function getList($conn){
    $result=array();
    $i=0;
    if($res = mysqli_query($conn, "SELECT * FROM seat ORDER BY absnum")){
        while ($row = mysqli_fetch_array($res)) {
            $result[$i++]=$row;
        }
        mysqli_free_result($res); 
    }else{
        throw new Exception("problem ritriving seats");
    }
    return $result;
}









?>