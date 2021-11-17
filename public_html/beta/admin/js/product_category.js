$(document).ready(function(){
	clicks = 0;
	$('#spanProductName').hide();
	$('#spanAvailableQty').hide();
	$('#spanProductUnitType').hide();
	$('#spanProductBrand').hide();
	$('#removeImage').hide();
	$('#spanAvailableClr').hide();
	$('#spanProductSize').hide();
});


//add textbox for adding new image while clicking 'Add Image' button
$('#addImage').click(function (){
	 clicks++;
	$('#hiddenImgVal').val(clicks);
	$("#addFile").append('<div id=img'+clicks+'><input class="form-control" type="text" name="productnewpics[]" id="productimg'+clicks+'" value="" data-toggle="modal" data-target="#exampleModal" data-whatever="productimg'+clicks+'" readonly placeholder="Click to select picture" style="margin-top:15px"> </div>')	
	if(clicks > 0){
		$('#removeImage').show();
	}
});


//remove textbox for removing existing image while clicking 'Remove Image' button
$('#removeImage').click(function(){
	hiddenRemoveVal	=	$('#hiddenImgVal').val();
	$('#productimg'+hiddenRemoveVal).remove();
	clicks--;
	$('#hiddenImgVal').val(clicks);
	hiddenImgVal = $('#hiddenImgVal').val();
	if(hiddenImgVal <= 0){
		$('#removeImage').hide();
	}
		
});
	

//Product Name validation of removing curly braces ,semicolumn and tags
$("#prod_name").keyup(function() {
	$('#submit').attr('disabled',false);
	
	pname = $('#prod_name').val(); 
	if(pname != ""){
		if (pname.match('[;<>{}]') ) {
		$('#spanProductName').show();
        $('#submit').attr('disabled',true);
		} else {
			$('#spanProductName').hide();
			$('#submit').attr('disabled',false);
		}
	}else{
		$('#spanProductName').text("This field is required");
		$('#spanProductName').show();
		$('#submit').attr('disabled',true);
	}
   
});

//Quantity Validation
$('#availQty').keyup(function(){
	qty = $('#availQty').val();
	$('#spanAvailableQty').hide();
	$('#submit').attr('disabled',false);
	if(qty == ""){
		$('#spanAvailableQty').hide();
		$('#submit').attr('disabled',false);
	}else{
			if($.isNumeric(qty)){
			$('#spanAvailableQty').hide();
			$('#submit').attr('disabled',false);
		}else{
			$('#spanAvailableQty').show();
			$('#submit').attr('disabled',true);
		}
	}			 
});

//No script tag allowed for product unit type
$('#prodUnit').keyup(function(){
	prodUnit = $('#prodUnit').val();
		if (prodUnit.match('[;<>{}]') ) {
		$('#spanProductUnitType').show();
        $('#submit').attr('disabled',true);
		} else {
			$('#spanProductUnitType').hide();
			$('#submit').attr('disabled',false);
		}		 
});


//No script tag allowed for product color
$('#availColor').keyup(function(){
	availColor = $('#availColor').val();
		if (availColor.match('[;<>{}]') ) {
		$('#spanAvailableClr').show();
        $('#submit').attr('disabled',true);
		} else {
			$('#spanAvailableClr').hide();
			$('#submit').attr('disabled',false);
		}		 
});

//No script tag allowed for product size
$('#prodSize').keyup(function(){
	prodSize = $('#prodSize').val();
		if (prodSize.match('[;<>{}]') ) {
		$('#spanProductSize').show();
        $('#submit').attr('disabled',true);
		} else {
			$('#spanProductSize').hide();
			$('#submit').attr('disabled',false);
		}		 
});


//No script tag allowed for product brand
$('#prodBrand').keyup(function(){
	prodBrand = $('#prodBrand').val();
		if (prodBrand.match('[;<>{}]') ) {
		$('#spanProductBrand').show();
        $('#submit').attr('disabled',true);
		} else {
			$('#spanProductBrand').hide();
			$('#submit').attr('disabled',false);
		}
});

//Image Close
$('.btnImgClose').click(function() {
    btnCloseID =  this.id ;
	var divid = $(this).closest('div').prop('id');
	$('#'+divid).remove();	
});

$('#reset').click(function(){ // reset the value inside the form
	//location.reload();
	  $("#prodCategoryForm")[0].reset();
});


	

					