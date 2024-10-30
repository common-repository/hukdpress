jQuery(document).ready(function($) {
	
	collapseScrollers();

  $('.hp_container').each(function(i) {
  	var elementID = this.id;
  	var postid = elementID.replace('hp_deal_','');
  	var data = {
			action: 'updateCacheForPost',
			post_id: postid
		};
		
		var conWidth = $(this).innerWidth();
		var statusWidth = $(this).children('.hp_deal_bottom').children('.hp_deal_status').outerWidth();
		var poweredWidth = $(this).children('.hp_deal_bottom').children('.hp_deal_powered').outerWidth();
		var newWidth = conWidth - statusWidth - poweredWidth - 2;
		if (newWidth > 0) $(this).children('.hp_deal_bottom').children('.hp_deal_selector').css('width',newWidth);
		
		$(this).children('.hp_deal_bottom').children('.hp_deal_status').children('.hp_deal_status_text').html('Checking For Updates..');
		
		
		$.post(ajaxurl, data, function(response) {
			var element = "#"+elementID;
			if (response !== "fail") {
				$(element).html(response);
			} else {
				$(element).children('.hp_deal_bottom').children('.hp_deal_status').html('Update Failed');
			}
			if (newWidth > 0) $(element).children('.hp_deal_bottom').children('.hp_deal_selector').css('width',newWidth);
			
			resetClicks();
			
			$("#"+elementID).children('.hp_scroll').each(function(i) {
				eid = this.id;
				registerScroll(eid);
			});
			
		});
  });
    
});

function collapseScrollers() {
	jQuery('.hp_scroll').each(function(i) {
  	var kids = jQuery(this).children('.hp_deal');
  	var first = true;
  	jQuery(kids).each(function(i) {
  		if (!first) {
  			jQuery(this).css('height',0);
  		}
  		jQuery(this).css('background-color',rowcolor);
  		if (first) first = false;
  	});
 })
}

function registerScroll(eid) {
	ele = "#"+eid;
	var kids = jQuery(ele).children('.hp_deal');
	jQuery(ele).data('dealCount',kids.length);
	var first = true;
	var maxHeight = 0;
	jQuery(kids).each(function(i) {
		if (jQuery(this).innerHeight() > maxHeight) maxHeight = jQuery(this).innerHeight();
		if (!first) {
			jQuery(this).css('height',0);
		}
		jQuery(this).css('background-color',rowcolor);
		if (first) first = false;
	});
	var selector = false;
	var parents = jQuery(ele).parent();
	var sel = jQuery(parents[0]).children('.hp_deal_bottom').children('.hp_deal_selector');
	for(var i=0;i<kids.length;i++) {
		var element = document.createElement('div');
		element.id = parents[0].id+"_sel_dot_"+i;
		jQuery(element).data('myNumber',i);
		jQuery(element).addClass('hp_selector_dot');
		if (i==0) jQuery(element).addClass('selected');
		jQuery(sel[0]).append(element);
		jQuery(element).click(function() {
			if (jQuery(ele).data('timer')) clearTimeout(jQuery(ele).data('timer'));
			var click = jQuery(this).data('myNumber');
			var scrollers = jQuery(this).parent().parent().parent().children('.hp_scroll');
			tweenDeal(scrollers[0].id,click)
		});
	}
		
	var conWidth = jQuery(parents[0]).innerWidth();
	var statusWidth = jQuery(parents[0]).children('.hp_deal_bottom').children('.hp_deal_status').outerWidth();
	var poweredWidth = jQuery(parents[0]).children('.hp_deal_bottom').children('.hp_deal_powered').outerWidth();
	var newWidth = conWidth - statusWidth - poweredWidth - 2;

	var content = newWidth-(10 * kids.length);
	var leftPadding = Math.floor(content/2);
	newWidth = newWidth - leftPadding;
	if (newWidth > 0) jQuery(parents[0]).children('.hp_deal_bottom').children('.hp_deal_selector').css('width',newWidth);
	if (leftPadding > 0) jQuery(parents[0]).children('.hp_deal_bottom').children('.hp_deal_selector').css('padding-left',leftPadding);
	
	jQuery(ele).data('showingDeal',1);
	jQuery(ele).data('useAlt',true);
	jQuery(ele).data('maxHeight',maxHeight);
	jQuery(ele).css('height',maxHeight);
	var func = function() { tweenDeal(eid) };
	var timer = setTimeout(func,scrolltime);
	jQuery(ele).data('timer',timer);
}

function tweenDeal(pid,click) {
	eid = "#"+pid;
	var maxHeight = jQuery(eid).data('maxHeight');
	var kids = jQuery(eid).children('.hp_deal');
	var showing = jQuery(eid).data('showingDeal');
	var max = jQuery(eid).data('dealCount');
	if (typeof(click) == "undefined") {
		if (showing == max) var newShow = 1; else newShow = showing + 1;
	} else {
		newShow = click+1;
	}
	
	if (showing != newShow) {
		if (jQuery(eid).data('useAlt')) {
			jQuery(eid).data('useAlt',false);
			jQuery(kids[newShow-1]).css('background-color',altrowcolor);
		} else {
			jQuery(eid).data('useAlt',true);
			jQuery(kids[newShow-1]).css('background-color',rowcolor);
		}
		jQuery(kids[showing-1]).animate({'height':0});
		jQuery(kids[newShow-1]).animate({'height':maxHeight});
		var selector = jQuery(eid).parent().children('.hp_deal_bottom').children('.hp_deal_selector').children('.hp_selector_dot');
		jQuery(selector[showing-1]).removeClass('selected');
		jQuery(selector[newShow-1]).addClass('selected');
		jQuery(eid).data('showingDeal',newShow);
	}
	var func = function() { tweenDeal(pid) };
	var timer = setTimeout(func,scrolltime);
	jQuery(eid).data('timer',timer);
}

function resetClicks() {
	jQuery('.hp_deal_powered').each(function(i) {
		if (!jQuery(this).hasClass('notrans')) {
			jQuery(this).unbind('click');
			jQuery(this).css('cursor','pointer');
			jQuery(this).click(function() {
				window.open('http://www.hotukdeals.com', 'hotukdeals');
			});
		}
	});
	jQuery('.hp_tip').tipTip({maxWidth: "180px"});
}