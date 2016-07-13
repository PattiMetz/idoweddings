jQuery("document").ready(function(){
	
	/*=========Images on homepage==========*/
	function showMoreImg() {
		jQuery('.sort_list a').click(function() {
			jQuery('.sort_list a').removeClass('active');
			jQuery(this).addClass('active');
			var linkID = jQuery(this).attr('id');
			setTimeout(function() {
				jQuery('.image_list').hide();
				jQuery('#to_' + linkID).fadeIn();
			},500);
			return false;
		});
	}
	showMoreImg();
	
	/*=========Select Chosen Plugin==========*/
	jQuery('select').chosen({disable_search_threshold: 10});
	
	/*========Bootstrap carousel========*/
	jQuery('#carousel-example-generic2').carousel({
	});
	
	/*=========Change Contact form==========*/
	function changeContactForm(){	
		var OptVal = jQuery('#contact_select').val();
		if(OptVal == "venue"){
			jQuery('.contact_block').hide();
			jQuery('.venue_block').show();
		}
		else if(OptVal == "vendor"){
			jQuery('.contact_block').hide();
			jQuery('.vendor_block').show();
		}
		else if(OptVal == "bridegroom"){
			jQuery('.contact_block').hide();
			jQuery('.couple_block').show();
		}
		else if(OptVal == "other"){
			jQuery('.contact_block').hide();
			jQuery('.other_block').show();
		}	
		else {
			jQuery('.contact_block').hide();
			jQuery('.travel_block').show();
		}
	}
	changeContactForm();
	
	jQuery('#contact_select').change(function() {
		changeContactForm();
	});
	
	/*=========Navigation==========*/
	jQuery('.navbar_sm').superfish({});
	jQuery('.internal_link').click(function(event){

		event.preventDefault();
		var full_url = this.href;
		var parts = full_url.split("#");
		var trgt = parts[1];
		var target_offset = $("#"+trgt).offset();
		var target_top = target_offset.top;
	
		jQuery('html,body').animate({scrollTop:target_top -85}, 900);
		
		var anchor = jQuery(this).attr("id");
		jQuery('.loc_box').hide();
		jQuery("#block_" + anchor).show();
		jQuery(".submenu_panel .default_list a").removeClass("active");
		
	});
	jQuery('#beach').on('click', function(e) {
		jQuery('#link_to1').addClass('active');
	});
	jQuery('#gazebo').on('click', function(e) {
		jQuery('#link_to2').addClass('active');
	});
	jQuery('#garden').on('click', function(e) {
		jQuery('#link_to3').addClass('active');
	});
	
	jQuery('.gen_menu > li a').click(function() {
		jQuery('.gen_menu > li a').removeClass('active');
		jQuery(this).addClass('active');
	});
	jQuery('.sub_menu li a').click(function() {
		jQuery('.sub_menu li a').removeClass('active');
		jQuery(this).closest('.sub_menu').prev('a').addClass('active');
	});
	jQuery('.menu_panel .default_list a').click(function() {
		jQuery('.menu_panel .default_list a').removeClass('active');
		jQuery(this).addClass('active');
	});

	jQuery(".loc_box").hide();
	jQuery(".loc_box.active").show();
	jQuery(".submenu_panel .default_list a").click(function(){
		jQuery(".submenu_panel .default_list a").removeClass("active");
		jQuery(this).addClass("active");
		var address = jQuery (this).attr("href");
		jQuery(".loc_box").removeClass("active").hide();
		jQuery(address).addClass("active").show(); 
		return false;		
	});
	
	/*=========Mobile menu==========*/
	jQuery('.mob_btn').click(function() {
		if ( jQuery(this).hasClass('clicked') ) {
			jQuery(this).removeClass('clicked');
			jQuery(this).next('ul').animate({ right: '-175px' }, 500);
		} else {
			jQuery(this).addClass('clicked');
			jQuery(this).next('ul').animate({ right: '0' }, 500);
		}
	});
	jQuery('.navbar_sm li a').click(function() {
		jQuery(this).closest('.navbar_sm').find('ul:first').animate({ right: '-175px' }, 500);
		jQuery(this).closest('.navbar_sm').find('ul:first').prev('.mob_btn').removeClass('clicked');
	});
	
});