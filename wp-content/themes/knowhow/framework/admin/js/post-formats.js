jQuery(document).ready(function() {


/*----------------------------------------------------------------------------------*/
/*	Video Post Format
/*----------------------------------------------------------------------------------*/

	var videoOptions = jQuery('#st_meta_box_video');
	var videoTrigger = jQuery('#post-format-video');
	
	videoOptions.css('display', 'none');
	

/*----------------------------------------------------------------------------------*/
/*	Functions
/*----------------------------------------------------------------------------------*/

	var group = jQuery('#post-formats-select input');

	
	group.change( function() {
		
		if(jQuery(this).val() == 'video') {
			videoOptions.css('display', 'block');
			stHideAll(videoOptions);
						
		} else {
			videoOptions.css('display', 'none');
		}
		
	});
		
	if(videoTrigger.is(':checked'))
		videoOptions.css('display', 'block');
		
	function stHideAll(notThisOne) {
		videoOptions.css('display', 'none');
		notThisOne.css('display', 'block');
	}
	
	

});