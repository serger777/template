//placeholder
jQuery(document).ready(function() {

	var dtGlobals = {}; // Global storage
	dtGlobals.isMobile	= (/(Android|BlackBerry|iPhone|iPad|Palm|Symbian|Opera Mini|IEMobile|webOS)/.test(navigator.userAgent));
	dtGlobals.isAndroid	= (/(Android)/.test(navigator.userAgent));
	dtGlobals.isiOS		= (/(iPhone|iPod|iPad)/.test(navigator.userAgent));
	dtGlobals.isiPhone	= (/(iPhone|iPod)/.test(navigator.userAgent));
	dtGlobals.isiPad	= (/(iPad|iPod)/.test(navigator.userAgent)); 
	
	jQuery('.cycle-sentinel').magnificPopup({
	      type: 'image',
	      closeOnContentClick: true,
	      image: {
	        verticalFit: false
	      }
    });

	jQuery('input, textarea').placeholder();
	
	// Set options
	if( !dtGlobals.isMobile ) {
	    var options = {
	        offset: '#showHere',
	        classes: {
	            clone:   'banner--clone',
	            stick:   'banner--stick',
	            unstick: 'banner--unstick'
	        }
	    };

	    // Initialise with options
	    var banner = new Headhesive('.banner', options);
	}
	
	/*************** Pages menu ****************/
	
	var pagfix = jQuery('.footer-widget li.page_item a, .footer-widget li.menu-item a, .footer-widget li.cat-item a').html();
    jQuery('.footer-widget li.page_item a, .footer-widget li.menu-item a, .footer-widget li.cat-item a').each(function(){
            var pagfix = jQuery(this).html();
            jQuery(this).html('').append('<i class="fa fa-caret-right"></i>'+pagfix);
    });
	
	
	var sidebar_widget_li = jQuery('.con-sidebar .widget li').html();
    jQuery('.con-sidebar .widget li').each(function(){
            var sidebar_widget_li = jQuery(this).html();
            jQuery(this).html('').append('<i class="fa fa-caret-right"></i>'+sidebar_widget_li);
    });
	//Remove empy <p></p>
	jQuery("p").filter( function() {
    	return jQuery.trim(jQuery(this).html()) == '';
	}).remove()
	
});
//Homepage Carousel
/*jQuery(document).ready(function(){
	jQuery('#realto-carousel').carousel({
		interval: 5000
	});
});*/
//Add classes to idv search form
jQuery(document).ready(function(){
	jQuery( ".dsidx-widget select" ).addClass( "select form-control" );
	jQuery( ".dsidx-widget input[type='text']" ).addClass( "form-control" );
});

jQuery.ready(function() {
	$('.carousel').carousel({
		interval: 8000

	})
});