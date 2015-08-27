(function ($) {
    "use strict";
	$(function () {
		// Place your administration-specific JavaScript here 

        
        // 3trigger for edit entry on list
        
         jQuery('#f_m_edit').live("click", function(event) {
            
            event.preventDefault();
            var href = jQuery(this).attr('href');
            //var fm_test = jQuery(event.target.attr('href')); 
            //alert(href);
            jQuery('#f_m_edit_form').empty();
            //Call edit form 
            var f_m_action_url = "f_m_get_edit_form";
            jQuery.ajax(
                				{
            						url: 'http://www.test-sw2.com/wp35/wp-admin/admin-ajax.php',
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    data: "fm_edit_id=" + href + "&action=" + f_m_action_url,
                                    success: function(result) 
            						{
            						//alert("end of call edit form " + result);
                       				jQuery('#f_m_edit_form').append(result);
            						}
            					}
            				);
            
            
            
            
            
            
            //jQuery('#f_m_edit_form').append( "<p>Test</p>" );
            
            //jQuery('#f_m_resp_data').empty();
            
            //
            
             
         });
         
         
// Check data then send to UPDATE script
                
                jQuery('#editupdatename').live("click", function(event) {
                    event.preventDefault();
                    //alert("test form running2");
                    var update_id_fm = jQuery(this).attr('height');
                    var action_url_up = "fm_send_update";
                	var name_up    = jQuery('#f_m_name_email_edit').val();
            		var email_up    = jQuery('#f_m_email_edit').val();
            		var emailReg_up = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              		//alert("test form running3" + name_up + email_up);
                      //if(emailReg_up.test(email_up))
            		//{
                		if(name_up!="" && email_up!=""){
                            var formSerial22 = jQuery(".michael1").serialize();
                            //alert("juste before ajax request" + formSerial22);
                            jQuery( ".michael1" ).css( "border", "3px solid red" );
            				jQuery.ajax(
            					{
            						url: 'http://www.test-sw2.com/wp35/wp-admin/admin-ajax.php',
            						type: 'POST',
            						//data: jQuery("#f_m_input").serialize() + "&action=" + action_url,
                                    data: jQuery(".michael1").serialize() + "&action=" + action_url_up + "&update_id_fm=" + update_id_fm,
                                    success: function(result) 
            						{
            						//alert("end of update Form " + result);
                       				jQuery('#f_m_resp_data').empty();
                                    jQuery('#f_m_resp_data').html(result);
            						}
            					}
            				);
                            //alert("failed test");
            			//	return false;
            			}
					else{
						
						alert("please add a valid name and email address");
						return false;
					}				
            		//}
		
	     }); 
        
 // Check data then send to DELETE script
                
                jQuery('#delete').live("click", function(event) {
                    event.preventDefault();
                    //alert("test form running2");
                    
                    var delete_id_fm = jQuery(this).attr('href');
                    var action_url_up = "fm_send_delete";
                    
              		//alert("test form running3 " + delete_id_fm + action_url_up);
                      
                	
            				jQuery.ajax(
            					{
            						url: 'http://www.test-sw2.com/wp35/wp-admin/admin-ajax.php',
            						type: 'POST',
            						data: "action=" + action_url_up + "&delete_id_fm=" + delete_id_fm,
                                    success: function(result) 
            						{
                                    //alert("end of update Form " + result);
                                    jQuery('#f_m_resp_data').empty();
                                    jQuery('#f_m_resp_data').html(result);
            						
                       				}
            					}
            				);
                           
		
	     });            
        
        
        
        
	});
}(jQuery));