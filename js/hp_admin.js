jQuery(document).ready(function($) {
	
	jQuery('.hp_tip').tipTip({maxWidth: "180px"});

  if ($('.hp_require_js')) {
  	$('.hp_require_js').hide();
  }
  
  
  if ($('.hp_if_js')) {
  	$('.hp_if_js').show();
  }
  
  if ($('.hp_with_colorpicker')) {
  	$('.hp_with_colorpicker').each(function(i) {
  		var value = $(this).attr('value');
  		if (value[0] == "#") value = value.substring(1);
  		if (value.length != 6) value = value[0] + value[0] + value[1] + value[1] + value[2] + value[2];
  		var ele = this;
  		$(this).ColorPicker({
  			'color': value,
	  		'onChange': function(hsb,hex,rgb) {
	  			if ((hex[0] == hex[1]) && (hex[2] == hex[3]) && (hex[4] == hex[5])) var hex = hex[0] + hex[2] + hex[4];
	  			$(ele).attr('value','#'+hex);
	  		}
  		});
  	});
  }
  
  if ($('#hp_apiopt_merch')) {
		resetApioptMerchBox();
		$('#hp_apiopt_merch').focus(function() {
			if ($('#hp_apiopt_merch').attr('value') == "Leave blank for all") {
				$('#hp_apiopt_merch').css('color','#666');
				$('#hp_apiopt_merch').css('font-style','normal');
				$('#hp_apiopt_merch').attr('value','');
			}
		});
		$('#hp_apiopt_merch').blur(resetApioptMerchBox);
	}

  
  if ($('#hp_show_for_post')) {
  	if ($('#hp_show_for_post').attr('checked')) {
  		$('#hukdpress_options').show();
   	}
  }
  
  $('#hp_show_for_post').click(function() {
  	if ($('#hp_show_for_post').attr('checked')) {
  		$('#hukdpress_options').show();
  		$('#hp_show_in_post_summary').attr('checked',true);
  		$('#hp_show_in_post_detail').attr('checked',true);
  	} else {
  		$('#hukdpress_options').hide();
  	}
  });
  
});

function resetApioptMerchBox() {
	if (jQuery('#hp_apiopt_merch').attr('value') == "") {
		jQuery('#hp_apiopt_merch').css('color','#AAA');
		jQuery('#hp_apiopt_merch').css('font-style','italic');
		jQuery('#hp_apiopt_merch').attr('value','Leave blank for all');
	}
}