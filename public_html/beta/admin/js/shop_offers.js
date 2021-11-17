// JavaScript Document

$(document).ready(function () {
	// hide all span by default
        $('#spanPercentage').hide();
	    $('#spanflatOfferL').hide();
		$('#spanBuyGetOfferL').hide();
		$('#spanCashbackOfferL').hide();
		$('#spanIdImageL').hide();
		$('#spanOfferName').hide();
    });



$('#offertype').change(function (){	
	$('#submit').attr('disabled',true);
	offertype = $('#offertype').val();
	if(offertype == "discount") 
	{
		$('.offerL').show();
	}else if(offertype == "flat"){
		$('.flatpercent').show();
	}else if(offertype == "buy-get"){
		$('#buyGetL').show();
	}else if(offertype =="cashback"){
		$('.cashBackL').show();
	}else{
		$('#submit').attr('disabled',false);
	}
	
});

$('#reset').click(function(){ // reset the value inside the form
	//location.reload();
	  $("#register_form")[0].reset();
});




	

		//Validation for discount offer
		$('.offerL').keyup(function (){
		$('#spanPercentage').hide();
		var percentage 	   = $('#percentage').val();
		var dirhams    = $('#dirhams').val();
		if ( (percentage <= 0) && (dirhams <= 0) ) {
			$('#spanPercentage').css("color","red");
			$('#spanPercentage').show();
			$('#submit').attr('disabled',true);
		}else if ( (percentage > 0) && (dirhams > 0) ) {
			$('#spanPercentage').css("color","red");
			$('#spanPercentage').show();
			$('#submit').attr('disabled',true);
		}
			else{
			$('#spanPercentage').hide();
			$('#submit').attr('disabled',false);
		}

	});

// Validation for Flat-percent offer
	$('.flatpercent').keyup(function (){

		var flatPercentageS    = $('#flatPercentageS').val();
		var flatPercentageE    = $('#flatPercentageE').val();
			
		if ( (flatPercentageS <= 0) || (flatPercentageE.length <= 0)) {
		   $('#spanflatOfferL').show();
		   $('#submit').attr('disabled',true);
		}	
		else if(flatPercentageE <= flatPercentageS ){
			$('#spanflatOfferL').show();
			$("#spanflatOfferL").text('Second sales value must be greater than first');
			$('#submit').attr('disabled',true);
		}
		else{
			$('#spanflatOfferL').hide();
			$('#submit').attr('disabled',false);
		}

	});

// Validation for Buy-Get offer
	$('.buyGetL').keyup(function (){

		var buy    = $('#buy').val();
		var get    = $('#get').val();

		if ( (buy <= 0) || (get <= 0) ) {
		  $('#spanBuyGetOfferL').show();
		  $('#submit').attr('disabled',true);	
		}
		else if ( (buy <= 0) && (get <= 0) ) {
		  $('#spanBuyGetOfferL').show();
		  $('#submit').attr('disabled',true);	
		}
		else if ( buy <get )  {
		  $('#spanBuyGetOfferL').text("Get value must be less than Buy value");
		  $('#submit').attr('disabled',true);	
		}
		else{
			$('#spanBuyGetOfferL').hide();
			$('#submit').attr('disabled',false);
		}
	});

// Validation for cashback offer
	$('.cashBackL').keyup(function (){

		var purchase = $('#purchase').val();
		var cashback = $('#cashback').val();

		if ( (purchase <= 0) || (cashback <= 0) ) {
		   $('#spanCashbackOfferL').show();
		   $('#submit').attr('disabled',true);	
		}
		else if(purchase < cashback ){
			$('#spanCashbackOfferL').show();
			$("#spanCashbackOfferL").text('Purchase must be greater than or equal to Cashback');
			$('#submit').attr('disabled',true);	
		}
		else{
			 $('#spanCashbackOfferL').hide();
			$('#submit').attr('disabled',false);	
		}

	});

//offer Name validation of removing curly braces ,semicolumn and tags
$("#offername").keyup(function() {
	$('#submit').attr('disabled',false);
    if ($(this).val().match('[;<>{}]') ) {
		$('#spanOfferName').show();
        $('#submit').attr('disabled',true);
    } else {
		$('#spanOfferName').hide();
        $('#submit').attr('disabled',false);
    }
});
	
/**  Validation to check whether the image is exists or not
*/

$(document).on("submit", "form", function(e){
	var rurl = $('#bannerimg').val();
	$('#bannerimg1').attr("src",rurl);
	
	if(rurl == ''){
		$('#spanIdImageL').show();
		e.preventDefault();
    	return  false;
		 
	}else{
		$('#spanIdImageL').hide();
		$('#submit').attr('disabled',false);
		return true;
		
	}
    
});