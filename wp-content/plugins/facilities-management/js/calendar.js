(function($) {
    $(function() {
		
		// Check to make sure the input box exists
		if( 0 < $('#datepicker').length ) {
			$('#datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
		} // end if
        
        // See date format 
        
        jQuery("#calendarsend").live('click', function (event) {
                   
                   
                   event.preventDefault();
                   var calendar_trial;
                   calendar_trial = jQuery('#datepicker').val();
                   alert("date format " + calendar_trial);
                   var action_url_calendar = "fm_insert_date";
                   var fm_date    = jQuery('#datepicker').val();
            		var fm_title    = jQuery('#fm_title').val();
            		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              		
                		if(fm_date!="" && fm_title!=""){
                            //var formSerial = jQuery("#f_m_input").serialize();
                            //alert(formSerial);
            				jQuery.ajax(
            					{
            						url: 'http://www.test-sw2.com/wp35/wp-admin/admin-ajax.php',
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    data: jQuery("#f_m_input_calendar").serialize() + "&action=" + action_url_calendar,
                                    success: function(result) 
            						{
            						//alert("end of update Form " + result);
                       				jQuery('#f_m_resp_data').html(result);
            						}
            					}
            				);
            				return false;
            			}
            		
                  
                    
                });
                
        
		
	});
}(jQuery));