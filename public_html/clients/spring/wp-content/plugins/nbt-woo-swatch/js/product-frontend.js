jQuery(document).ready(function($j) {
      if (nbtws.tooltip == "yes") {
		  $j('label').miniTip();
	  }
      
      
	  
	   
	   $j('form.variations_form').on( 'click', 'label', function() {
	      $j( this ).closest('.attribute-swatch').find('.selectedswatch').removeClass('selectedswatch').addClass('nbtwsswatchlabel');
	      $j( this ).removeClass('nbtwsswatchlabel').addClass( 'selectedswatch' );
			
         var selectid= $j(this).attr("selectid");
         var option = $j(this).attr("data-option");

        //find the option to select
        var optionToSelect = parent.jQuery("form.variations_form #" + selectid + "").children("[value='" + option + "']");

         //mark the option as selected
        optionToSelect.prop("selected", "selected").change();
       
	  

		 
       } );	   
  
       
       $j('form.variations_form').on( 'click', '.reset_variations', function() {
			$j('form.variations_form').find('.selectedswatch').removeClass('selectedswatch').addClass('nbtwsswatchlabel');
		} );
	   
});


