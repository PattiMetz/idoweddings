jQuery("document").ready(function(){
	
	/*========Left panel options========*/
	function openPanel() {
		var winWidth = jQuery(window).width();
		if ( winWidth > 750 ) {
			jQuery('.left_panel').hover(function() {
				jQuery(this).addClass('open');
			},function(){
				jQuery(this).removeClass('open');
			});
		}
		else {
			jQuery('.left_panel').hover(function() {
				jQuery(this).removeClass('open');
			});
		}
	}
	openPanel();
	
	jQuery('.item_list li').click(function() {
		jQuery(this).addClass('active');
		jQuery('.item_list li').not(this).removeClass('active');
	});
	
	function leftPanelHeight() {
		var winWidth = jQuery(window).width();
		var PanelHeight = jQuery('.main_wrapper').height();
		if ( winWidth > 750 ) {
			jQuery('.left_panel').css('height', PanelHeight).attr('style','');
			jQuery('.item_list').getNiceScroll().remove();
		}
		else {
			jQuery('.left_panel').css('height', 'auto');
			jQuery('.item_list').niceScroll({cursorcolor:"#fff", cursoropacitymax: "0.7"});	
		}
	}
	leftPanelHeight();
	
	jQuery('.mob_btn').click(function() {
		if ( jQuery(this).hasClass("clicked") ) {	
			jQuery('.left_panel').animate({ width: '256px' }, 500);
			jQuery(this).removeClass("clicked");
		}
		else {
			jQuery('.left_panel').animate({ width: '0' }, 500);
			jQuery(this).addClass("clicked");
		}
	});
	
	function listMenu() {
		jQuery('.left_panel:not(.open)').find('.item_list li a').click(function() {
			jQuery('.left_panel:not(.open)').css('width', '0');
			jQuery('.mob_btn').addClass("clicked");
		});		
	}
	listMenu();
	
	jQuery(document).click(function (event) {
		var winWidth = jQuery(window).width();
		if ( winWidth < 750 ) {
			if (jQuery(event.target).closest('.left_panel:not(.open)').length == 0 && $(event.target).attr('class') != 'mob_btn') {
				jQuery('.left_panel:not(.open)').animate({ width: '0' }, 500);
				jQuery('.mob_btn').addClass("clicked");
			}
		}
    });
	
	jQuery(window).resize(function(){
		openPanel();
		leftPanelHeight();		
		listMenu();
	});
	
	/*========Open kn base options========*/
	jQuery('.knbase_top a').click(function() {
		var linkID = jQuery(this).attr('id');
		var knName = jQuery(this).attr('name');
		jQuery('.main_base').hide();
		jQuery('#block_' + linkID).show();
		jQuery('.basename').text(knName);
	});
	jQuery('#it_15').click(function() {
		jQuery('.knbase_block').hide();
		jQuery('.main_base').show();
		jQuery('.basename').text('Overview');
		jQuery('.choose_base').find('.sel_btn').text('Knowledge Base Name');
	});
	
	function chooseBlock() {
		jQuery('.knbase_block').hide();
		jQuery (".general_block .active").show();
		jQuery(".choose_base .dropdown-menu a").click(function(){
			jQuery(".choose_base .dropdown-menu a").removeClass("active");
			jQuery(this).addClass("active");
			var address = jQuery(this).attr("href");
			jQuery(".knbase_block").removeClass("active").hide();
			jQuery(address).addClass("active").show();
			var itemName = jQuery(this).attr('name');
			jQuery('.choose_base').find('.sel_btn').text(itemName);
			jQuery('.basename').text(itemName);
			return false;
		});
	}
	chooseBlock();
	
	/*========Subcategory kn base options========*/	
	function chooseSubCategories () {
		jQuery('.category').click(function() {
			jQuery('.category').removeClass('active');
			jQuery(this).addClass('active');
			var address = jQuery(this).attr("href");
			jQuery(this).closest('.parent_box').hide();
			jQuery(".sub_box").removeClass("active").hide();
			jQuery(address).addClass("active").show();
			return false;
		});
	}
	chooseSubCategories();
	
	jQuery('.return_link').click(function() {
		jQuery(this).closest('.sub_box').hide();
		jQuery(this).closest('.knbase_block').find('.parent_box').show();
	});
	
	/*========Add category Modal========*/	
	function valInBtn() {
		jQuery('#gr_1 a').click(function() {
			var dropName = jQuery(this).attr('name');
			jQuery(this).closest('.btn-group').find('.sel_btn').text(dropName);
		});
		jQuery('#gr_2 a').click(function() {
			var dropName = jQuery(this).attr('name');
			jQuery(this).closest('.btn-group').find('.sel_btn').text(dropName);
		});
		jQuery('#gr_3 a').click(function() {
			var dropName = jQuery(this).attr('name');
			jQuery(this).closest('.btn-group').find('.sel_btn').text(dropName);
		});
		jQuery('#gr_4 a').click(function() {
			var dropName = jQuery(this).attr('name');
			jQuery(this).closest('.btn-group').find('.sel_btn').text(dropName);
		});
	}
	valInBtn();
	
	/*========Table arrows========*/
	jQuery('.doc_table td:first-child, .doc_table td:nth-child(2)').hover(function() {
		jQuery('.arrows').hide();
		jQuery(this).parent('tr').find('.arrows').show();
	},function(){
		jQuery(this).parent('tr').find('.arrows').hide();
	});
});