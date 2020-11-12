<?php //login.php
	include 'header.php';
	httpsRedirect();
	
	// If logged user, redirect to home
	if($loggedin){
		redirect("home.php");
	}
	
	// If there has been an error
	$errorText="";
	if (isset($_GET['msg'])){
		if($_GET['msg']=='error'){
			$errorText="Wrong username and/or password, try again";
		}else if($_GET['msg']=='timeout'){
			$errorText="The authentication time has expired: login to continue your booking process";			
		}
	}	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link href="css/home.css" rel="stylesheet" type="text/css">	
		<noscript style="color:blue;float:left;font-size: large;font-weight: bold;padding-left: 100px;padding-top: 20x;">
   <style>div { display:none }</style>
</noscript>		
	</head>
	<body>
	<div id="main">
		<h1>Login</h1>
		<p class="errorMsg"><?php echo $errorText;?></p>
		<form method="POST" action="loginPost.php">			
			<label>Insert your username:    <br><br> <input 
									id="username" 
									type="email" 
									name="username"
									placeholder="something@domain.com" 
									required></label><br>
			<label>Insert your password:  <br><br>   <input 
									id="psw1"
									type="password" 
									name="psw"
									placeholder="***************"
									required></label><br>
			<p id="errorMsg"></p>
			<input type="submit" id="submit" value="Login" class="button">			
		</form>
	</div>
	</body>
</html>