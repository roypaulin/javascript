<?php //home.php
	include 'header.php';
	include 'functions/homeFunctions.php';
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>AirBooking</title>
		<link href="css/home.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-3.3.1.min.js">
		</script>
		<script type="text/javascript" src="js/home.js">
		
		</script>
		<noscript style="color:blue;float:left;font-size: large;font-weight: bold;padding-left: 100px;padding-top: 20x;">
   <style>div { display:none }</style>
</noscript>
	</head>
	
	
	<body>
	
	
	<div id="main">
	<?php if($loggedin){?>
		<h2>Hello <?php echo htmlentities($user);?></h2>
	<?php }?>
	<h2>Seats Map</h2>
	
	
	      <p id="errMsg5" ></p>
			   <div id="myDiv">
				<?php getTableAndSeatDetails($row_num,$column_num);?>
				
			</div>
	
		<?php if($loggedin){
		    ?>	
					
				<button class="button" type="submit"  id="update"> Refresh Button </button>
				<button class="button" id="buyButton"  >Buy</button>	
					 			
		<?php }?>
	</div>
	
	</body>
	
</html>
