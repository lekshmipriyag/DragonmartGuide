jQuery(document).ready(function(){
    var scripts = document.getElementsByTagName("script");
    var jsFolder = "";
    for (var i= 0; i< scripts.length; i++)
    {
        if( scripts[i].src && scripts[i].src.match(/initcarousel-1\.js/i))
            jsFolder = scripts[i].src.substr(0, scripts[i].src.lastIndexOf("/") + 1);
    }
    if ( typeof html5Lightbox === "undefined" )
    {
        html5Lightbox = jQuery(".html5lightbox").html5lightbox({
            skinsfoldername:"",
            jsfolder:jsFolder,
            barheight:64,
            showtitle:true,
            showdescription:false,
            shownavigation:false,
            thumbwidth:80,
            thumbheight:60,
            thumbtopmargin:12,
            thumbbottommargin:8,
            titlebottomcss:'{color:#333; font-size:14px; font-family:Armata,sans-serif,Arial; overflow:hidden; text-align:left;}',
            descriptionbottomcss:'{color:#333; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;}'
        });
    }
    jQuery("#amazingcarousel-1").amazingcarousel({
        jsfolder:jsFolder,
        width:190,
        height:250,
        skinsfoldername:"",
        interval:3000,
        itembottomshadowimagetop:99,
        donotcrop:false,
        random:false,
        showhoveroverlay:true,
        rownumber:1,
        height:250,
        arrowheight:60,
        showbottomshadow:false,
        itembackgroundimagewidth:100,
        imageheight:250,
        skin:"Highlight",
        responsive:true,
        lightboxtitlebottomcss:"{color:#333; font-size:14px; font-family:Armata,sans-serif,Arial; overflow:hidden; text-align:left;}",
        enabletouchswipe:true,
        navstyle:"none",
        backgroundimagetop:-40,
        arrowstyle:"none",
        bottomshadowimagetop:95,
        hidehoveroverlayontouch:false,
        continuous:false,
        itembackgroundimagetop:0,
        hoveroverlayimage:"hoveroverlay-64-64-5.png",
        itembottomshadowimage:"itembottomshadow-100-98-3.png",
        lightboxshowdescription:false,
        width:190,
        navswitchonmouseover:true,
        showhoveroverlayalways:false,
        transitioneasing:"easeOutExpo",
        lightboxshownavigation:false,
        showitembackgroundimage:false,
        itembackgroundimage:"",
        playvideoimagepos:"center",
        circular:true,
        arrowimage:"arrows-42-60-0.png",
        scrollitems:1,
        direction:"horizontal",
        lightboxdescriptionbottomcss:"{color:#333; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;}",
        supportiframe:false,
        navimage:"bullet-16-16-0.png",
        backgroundimagewidth:110,
        showbackgroundimage:false,
        lightboxbarheight:64,
        showplayvideo:true,
        spacing:4,
        lightboxthumbwidth:80,
        navdirection:"horizontal",
        itembottomshadowimagewidth:100,
        backgroundimage:"",
        lightboxthumbtopmargin:12,
        autoplay:true,
        lightboxnogroup:false,
        arrowwidth:42,
        transparent:false,
        continuousduration:2500,
        bottomshadowimage:"bottomshadow-110-95-0.png",
        scrollmode:"item",
        navmode:"page",
        lightboxshowtitle:true,
        lightboxthumbbottommargin:8,
        arrowhideonmouseleave:1000,
        showitembottomshadow:true,
        lightboxthumbheight:60,
        navspacing:8,
        pauseonmouseover:true,
        imagefillcolor:"FFFFFF",
        playvideoimage:"playvideo-64-64-0.png",
        transitionduration:1000,
        visibleitems:6,
        imagewidth:200,
        usescreenquery:false,
        bottomshadowimagewidth:110,
        screenquery:{
	tablet: {
		screenwidth: 900,
		visibleitems: 2
	},
	mobile: {
		screenwidth: 600,
		visibleitems: 1
	}
},
        navwidth:16,
        loop:0,
        navheight:16
    });
});