
// Select the main list and add the class "hasSubmenu" in each LI that contains an UL
$('.ulcls').each(function(){
  $this = $(this);
	$this.closest('.ulcls').css("border-left", "1px solid gray");
     $this.find(".licls").has(".ulcls").addClass("hasSubmenu");
});

// Add bold in li and levels above
$('.ulcls .licls').each(function(){
  $this = $(this);

  $this.mouseenter(function(){
    $( this ).children("a").css({"font-weight":"bold","color":"#336b9b"});
	 
  });
  $this.mouseleave(function(){
    $( this ).children("a").css({"font-weight":"normal","color":"#428bca"});
  });
});

// Add button to expand and condense - Using FontAwesome
$('.ulcls .licls.hasSubmenu').each(function(){
  $this = $(this);
	
  $this.prepend("<a href='#'><i class='fa fa-minus-circle'></i><i style='display:none;' class='fa fa-plus-circle'></i></a>");
	
	$this.children("a").addClass("toogle");
});


// Actions to expand and consense
$('.ulcls .licls.hasSubmenu a.toogle').click(function(){
  $this = $(this);
  $this.closest(".licls").children(".ulcls").slideToggle("slow");
  $this.children("i").toggle();
  return false;
});

