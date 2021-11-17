$(document).ready(function(){
	"use strict";
	$('#enquiry').hide();
	$('#shopdata').hide();
	$('#shopMsg').hide();
	$('#emptyMsg').hide();	
});


$('#password').change(function (){
"use strict";
var password = $('#password').val(); 

var confirm_password =$('#confirm_password').val();
	if(password.value !== confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
			confirm_password.setCustomValidity('');
		  }
});

$('#confirm_password').change(function (){
"use strict";
var password = $('#password').val(); 
var confirm_password =$('#confirm_password').val();

	if(password !== confirm_password) {
			$('#passwordConfirm').text('Password Mismatch');
			$('#passwordConfirm').css('color','red');
			$('#submit').hide();
			$('#passwordConfirm').show();
		  } else{
			  $('#passwordConfirm').hide();
			  	$('#submit').show();
		  }
});

$('#username').blur(function(){
	"use strict";
	 var userName	=	$("#username").val();
	$("#loaderIcon").show();
			jQuery.ajax({
					url: "username_availability.php",
					
					data:{
							"userName"		:userName
						},
					async:false,
					method: "POST",
					success:function(data){
						
						$("#user-availability-status").html(data);
						$("#loaderIcon").hide();
					},
					
				});
});

$('#txt_shopNumber').change(function (){
	
	"use strict";
	var shopNum = $('#txt_shopNumber').val();

				$.ajax({
					url:"ajax_login.php",
					data:{
							"shopNum"		:shopNum
						},
					async:false,
					method: 'POST',
					type: JSON,
					success: function(data)
						{  
							
							if(data === "No Data"){
								$('#txt_Message').val(shopNum);
								$('#shopdata').hide();
								$('#shopMsg').show();
								$('#shopMsg').css("color","red");
								$('#shopMsg').html("( Above some shops are currently unavailable. )");
								$('#enquiry').show();
								$('#shopErr').hide();
							
							}else if(data === ""){
								$('#shopMsg').hide();
								$('#enquiry').hide();
								$('#txt_Message').text('');
								$('#shopErr').show();
								$('#shopErr').text('shop number required');
								$('#emptyMsg').text('');
								$('#shopErr').css("color","red");
								$('#shopdata').hide();
							}
							else{
								$('#shopErr').hide();
								$('#shopMsg').hide();
								$('#enquiry').hide();
								$('#txt_Message').text('');
								$('#shopdata').show();
								$('#shopdata').html(data);
								
							}
						}	
				});

});


$('#txt_Message').keyup(function(){
	"use strict";
		var msgVal = $('#txt_Message').val();
				var len = $("#txt_Message").val().length;
				if(msgVal !== '' && len >= 15){
					$('#emptyMsg').hide();
					$('#submit').show();
				}else if(msgVal !== '' && len <= 15 ){ // validation for ad image
					$('#emptyMsg').show();
					$('#emptyMsg').css('color','red');
					$('#emptyMsg').text('Message Must be minimum of 15 characters');
					$('#submit').hide();
				}else if(msgVal === ''){
					$('#emptyMsg').show();
					$('#submit').hide();
				}else{
					$('#emptyMsg').hide();
					$('#submit').show();
				}
	
});

