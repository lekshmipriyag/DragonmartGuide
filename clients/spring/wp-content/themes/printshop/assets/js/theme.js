jQuery(document).ready(function() {
     "use strict";
  jQuery('.gridlist-toggle').each(function(){
    jQuery(this).find('#grid').addClass('active');
    jQuery(this).find('#list').removeClass('active');
    jQuery('.site-main ul.products').addClass('grid');
    jQuery('.site-main ul.products').removeClass('list');
  });   
    jQuery('.widget_maxmegamenu').each(function(){ 
      jQuery('.widget_maxmegamenu h3.widget-title').toggle(function() {
        jQuery('.widget_maxmegamenu .mega-menu-wrap').fadeOut('fast');
      }, function() {
        jQuery('.widget_maxmegamenu .mega-menu-wrap').fadeIn('fast');
      });
    });
    
    ( function() {
          var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
          is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
          is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;
          if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
           window.addEventListener( 'hashchange', function() {
            var element = document.getElementById( location.hash.substring( 1 ) );

            if ( element ) {
             if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
              element.tabIndex = -1;

          element.focus();
      }
       }, false );
       }
   })();

    ( function() {
          jQuery('.site-content').fitVids();
      })();

    
     /**
      * Initialise transparent header
      */
      ( function() {

         var site_header_h = jQuery('.site-header').height();
         var logo_h = jQuery('.site-branding img').height();
         var nav_h = jQuery('.wpc-menu').height() - 30;
         var page_header = jQuery('.page-header-wrap');
         var page_header_pt = parseInt(page_header.css('padding-top'), 10);

         if ( jQuery('body').hasClass('header-transparent') && page_header.length ) {
             page_header.css('padding-top', page_header_pt + site_header_h + 'px');
         }

     })();

      jQuery('.wpnetbase_asl_container').each(function(){
        jQuery('.header-search .fa-search').css('display','block');
      });
     /**
      * Back To Top
      */
      ( function() {
         jQuery('#btt').fadeOut();
         jQuery(window).scroll(function() {
             if(jQuery(this).scrollTop() != 0) {
                 jQuery('#btt').fadeIn();    
             } else {
                 jQuery('#btt').fadeOut();
             }
         });

         jQuery('#btt').click(function() {
             jQuery('body,html').animate({scrollTop:0},800);
         });
     })();

     /**
      * Fixed Header + Navigation.
      */
      ( function() {

         if ( header_fixed_setting.fixed_header == '1' ) {
             var header_fixed = jQuery('.fixed-on');
             var p_to_top     = header_fixed.position().top;

             jQuery(window).scroll(function(){
                 if(jQuery(document).scrollTop() > p_to_top) {
                     header_fixed.addClass('header-fixed');
                     header_fixed.stop().animate({},300);
                     if ( jQuery("body").hasClass('header-transparent') ) {
                         
                     } else {
                         jQuery('.site-content').css('padding-top', header_fixed.height());
                     }
                    
                 } else {
                     header_fixed.removeClass('header-fixed');
                     header_fixed.stop().animate({},300);
                     if (jQuery("body").hasClass('header-transparent') ) {
                         
                     } else {
                         jQuery('.site-content').css('padding-top', '0');
                     }
                 }
             });
         }

     })();
     /**
      * Jquery Add to wishlist
      */
     jQuery( "a.add_to_wishlist" ).html("");
     jQuery( "a.yith-wcqv-button" ).html("");
     jQuery( "a.compare" ).html("");
     

     jQuery( ".yith-wcwl-wishlistexistsbrowse a" ).html("");
     jQuery( ".yith-wcwl-wishlistaddedbrowse a" ).html("");
   
     jQuery( ".yith-wcwl-wishlistexistsbrowse .feedback" ).remove();
     jQuery( ".yith-wcwl-wishlistaddedbrowse .feedback" ).remove();
   
     jQuery( "a.add_to_wishlist" ).append( "<span>Wishlist</span>" );
     jQuery( "a.yith-wcqv-button" ).append( "<span>Quickview</span>" );
     jQuery( "a.compare" ).append( "<span>Compare</span>" );
     jQuery( ".yith-wcwl-wishlistexistsbrowse a" ).append( "<span>Browse Wishlist</span>" );
     jQuery( ".yith-wcwl-wishlistaddedbrowse a" ).append( "<span>Browse Wishlist</span>" );

     jQuery(".single-product #primary .summary .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a").attr("title", "Browse Wishlist");

     jQuery('.header-right-cart-search .header-search .fa-search').on('click', function() {
         jQuery(this).siblings('.wpnetbase_asl_container').slideToggle();
     });
      jQuery( "#netbase-responsive-toggle" ).on("click",function(e){
          e.preventDefault();
          jQuery(".header-right-wrap-top").animate({ width: 'toggle', height: '8335px'});
      });

      jQuery("#close-netbase-menu ").on("click",function(){
        jQuery(".header-right-wrap-top").animate({ width: 'toggle', height: '8335px'});
      }); 
      var $checkrtl = false;
      if (jQuery("html").attr("dir") == 'rtl'){ $checkrtl = true; }

      jQuery('body.single-product .thumbnails').addClass('owl-carousel');
       jQuery('body.single-product .thumbnails').owlCarousel({
        items: 3,rtl: $checkrtl,
        autoPlay: 3000,
        loop: true,
        margin: 10,
        lazyLoad : true,          
        navigation : true,
        navigationText: ['<i class="icon-left-open"></i>', '<i class="icon-right-open"></i>'],
       });


      jQuery('.shortcodes-lst-products-cat.nbcarousel').each(function(){
      jQuery('.shortcodes-lst-products-cat.nbcarousel .products').addClass('owl-carousel');
      jQuery('.shortcodes-lst-products-cat.nbcarousel .products').owlCarousel({
        items:4,nav : true, margin: 30, dots: false,rtl: $checkrtl,
        navText: ['<i class="fa fa-angle-left fa-2x"></i>', '<i class="fa fa-angle-right fa-2x"></i>'],
        responsive: {
        0: {
          items: 1,
        },
        480: {
          items: 2,
        },
        600: {
          items: 3,
        },
        992: {
          items: 4,

        },
      
        },
      });
  });
var $check1rtl = false;
      if (jQuery("html").attr("dir") == 'rtl'){ $check1rtl = true; }
  jQuery('.shortcodes-lst-products-cat.catchild-carousel').each(function(){
    jQuery('.shortcodes-lst-products-cat.catchild-carousel .products').addClass('owl-carousel');
    jQuery('.shortcodes-lst-products-cat.catchild-carousel .products').owlCarousel({
      items:3,nav : true, margin: 30, dots: false,rtl: $check1rtl,
      navText: ['<i class="fa fa-angle-left fa-2x"></i>', '<i class="fa fa-angle-right fa-2x"></i>'],
      responsive: {
        0: {
          items: 1,
        },
        480: {
          items: 2,
        },        
        992: {
          items: 3,

        },
      
      },
    });
  }); 
	var fbt = jQuery('.yith-wfbt-form .image-td').length;
	var width_frm = (jQuery('.yith-wfbt-form').width() - 147 - (fbt * 20)) / fbt;
	if(fbt < 4){
		var width_frm = 150;
	}
	jQuery('.yith-wfbt-section .yith-wfbt-images td img').css('width', width_frm);
        
});