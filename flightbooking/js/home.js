$(document).ready(function(){
	
	
	// FUNCTIONS
	
	color=undefined;
	clicked=false;
	//color2=undefined;
	
	/*$(window).bind('load',function(){
		alert('pazzo');
	});*/
 yellowseats=0;
function purchaseSeats(user){
	yellowseats=getYellowSeats();
	$.post("purchase.php",
			{
		 num : yellowseats
			},
			function(data){
		   
		   
		  
		    switch(data){
		    case "NONE":
		    	alert("none seats reserved");
		    	
		    	break;
		    case "SUCCESS": 
		    	alert("seats purchased successfully");
		    break;
		    case "PURCHASED":
		    	alert("error at least one of the reserved seats has been purchased");
		    	
		    	break;
		    	
		    case "ERROR":
		    	alert("operation failed due to some problems with the server");
		    break;
		    case "TIMEOUT":
		    	alert("session expired login to continue");
		    	break;
		    default:
		    	break;
		    }
		   
		   
		    window.location.reload();
	}
			);
}	
	


function getYellowSeats(){
	var i=1;
	var num=0;
	while($("#"+i).attr("id")!=undefined){
		if($("#"+i).hasClass("reservedByMe")){
			num++;
		}
		i++;
	}
	return num;
}




	function checkReservation(user){
		console.log($(user).attr('value'))
		if($( user ).hasClass( "reservedByMe" )){
			$.post("deleteReservation.php",
					{
				 seat: $(user).attr('value')
					},
					function(data){
						
						
						if(data!="TIMEOUT"){
							
							
							if(data=="FREE"){
							color='green';
							// $( this ).css({'background-color':'green'})
							$(user).attr("class","free");
							changeColor();
							$("#errMsg5").text("reservation cancelled successfully");
							$("#errMsg5").css("color","green");
							}else{
								if(data=="FAILED"){
								$("#errMsg5").text("operation failed due to some problems with the server");
							    $("#errMsg5").css("color","red");
							}else{
								if(data=="RESERVED"){
									color='orange';
									// $( this ).css({'background-color':'green'})
									$(user).attr("class","reserved");
									changeColor();
									$("#errMsg5").text("seat reserved by someone else");
								    $("#errMsg5").css("color","orange");
								}else{
								color='red';
								// $( this ).css({'background-color':'green'})
								$(user).attr("class","purchased");
								changeColor();
								$("#errMsg5").text("seat already purchased");
							    $("#errMsg5").css("color","red");
							}
							}
							}
							
							//$( "body" ).load("home.php");
						}else{
							 window.location.replace("login.php");
							
						}
					}
			);
		}else{
		$.post("checkReservation.php",
			    {
			        seat : $(user).attr('value')
			    },
			    function(data){
			    	//$("#errorMsg3").text("");
			    	
			    	
			    	if(data!="FREE"){
			    		
			    		switch(data){
			    		case "PURCHASED":
			    		color="red";
			    		$(user).attr("class","purchased");
			    		changeColor();
			    		$("#errMsg5").text("seat already purchased");
						$("#errMsg5").css("color","red");
			    		break;
			    		case "TIMEOUT":
			    				 window.location.replace("login.php");
			    		
			    			break;
			    			default:
			    				break;
			    				
			    	}
    					//$( "body" ).load("home.php");
			    	}else{
			    		
			    		$.post("saveReservation.php",
			    			{
			    			 seat : $(user).attr('value')
			    			
			    			},
			    			function(data,status){
			    				console.log(data);
			    				if(parseInt(data)>0){
			    					color="#C7CE4A";
			    					 //$( this ).css({'background-color':'#C7CE4A'});
			    					$(user).attr("class","reservedByMe");
			    					changeColor();
			    					
			    					$("#errMsg5").text("seat reserved successfully");
									$("#errMsg5").css("color","orange");
			    					
			    					 //$( "body" ).load("home.php");
			    				}else{
			    					$("#errMsg5").text("operation failed due to some problems with the server");
								    $("#errMsg5").css("color","red");
			    				}
			    			}
			    		);
			    		
			    	}
			    });
		}
	}
	
	function changeColor(user){
		var color2=undefined
		if(clicked){
			color = $( user ).css( "background-color" );
			if($( user ).hasClass( "free" ))
			     $( user ).css({'background-color':'#24DF60'});
			if($( user ).hasClass( "reserved" ))
			     $( user ).css({'background-color':'#D96917'});
			if($( user ).hasClass( "reservedByMe" ))
			     $( user ).css({'background-color':'#DCE62C'});
			if($( user ).hasClass( "purchased" ))
			     $( user ).css({'background-color':'#D9171A'});
		}
		
		
		
	}
	// ACTIONS
	//make easier identifying each seat
	
	$("td").mouseenter(function(){
		changeColor(this);
	});
	
	$("td").mouseleave(function (){
		  $( this ).css("background-color",color);
		  clicked=false;
	});
	
	
	$("td").click(function(){
		
		//console.log(yellowseats);
		if($(this).attr("isLog")){
			
		if(!$(this).hasClass("purchased")){
			clicked=true;
		checkReservation(this);
		}else{
			$("#errMsg5").text("seat already purchased");
		    $("#errMsg5").css("color","red");
		}
		}
	});
	
	 $("#update").click(function(){
		 window.location.reload();
	 })
	
	
	
	
	// clicking on buy button to purchased all reserved seats
	$("#buyButton").click(function(){
		purchaseSeats(this);
	});
	
	
	
	
	
});