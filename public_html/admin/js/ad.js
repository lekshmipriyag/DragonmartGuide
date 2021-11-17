
$(document).ready(function(){
	"use strict";
	$('#spanAdName').hide();
	$('#spanIdAdImage').hide();
	$('#newShop').hide();
	$('#spanNewShop').hide();
	var shopName	=	$('#adShopName').val();
	if(shopName === ''){
		$('#newShop').show();
	}
	var newshp = '';
	newshp = $('#newShopName').val();
	if(newshp !== '' && shopName === ''){
		$('#newShop').show();
	}
	
});

$('#btnClose').click(function(){
	"use strict";
	$('#modalId').hide();
});


$('.close').click(function(){
	"use strict";
	$('#modalId').hide();
});



$('#adShopName').change(function(){
	"use strict";
		var shopName = '';
		shopName	=	$('#adShopName').val();
		if(shopName === '') {
			$('#newShop').show();
		}else{
			$('#newShop').hide();
			$('#spanNewShop').hide();
		}
});

$('#newShopName').keyup(function(){
	"use strict";
	var newshop = '';
	$('#submit').attr('disabled',false);
	newshop = $('#newShopName').val();
	if(newshop !== ''){
		$('#spanNewShop').hide();
	}	
    if ($(this).val().match('[;<>{}]') ) {
		$('#spanNewShop').show();
		$('#spanNewShop').text('Invalid Shop Name');
        $('#submit').attr('disabled',true);
    } else {
		$('#spanNewShop').hide();
        $('#submit').attr('disabled',false);
    }
});

$('#adname').keyup(function(){
	"use strict";
	$('#submit').show();
	var adName = '';
	adName	=	$('#adname').val();
	if(adName !== ""){
		if(adName.match('[;<>{}]')){  // for avoid ;,<> 
			$('#spanAdName').show();
			$('#submit').hide();
		}else{
			$('#spanAdName').hide();
			$('#submit').show();
		}
	}else{
		$('#spanAdName').text("This field is required");
		$('#spanAdName').show();
		$('#submit').hide();
	}
});

$('#reset').click(function(){ // reset the value inside the form
	//location.reload();
	  $("#register_form")[0].reset();
});

/**  Validation to check whether the image is exists or not
*/

$(document).on("submit", "form", function(e){
	"use strict";
	var rurl = $('#bannerimg').val();
	$('#bannerimg1').attr("src",rurl);
	
	var newshop;
	newshop = $('#newShopName').val();
	var shopName	=	$('#adShopName').val();
	if(newshop === '' && shopName === ''){ // return false when shop name is not added
			$('#spanNewShop').show();
			e.preventDefault();
    		return  false;
		}

	if(rurl === ''){ // validation for ad image
		$('#spanIdAdImage').show();
		e.preventDefault();
    	return  false;
		 
	}
	else{
		$('#spanIdAdImage').hide();
		$('#submit').attr('disabled',false);
		return true;
		
	}
    
});

