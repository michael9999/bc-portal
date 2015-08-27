(function ($) {
	"use strict";
	$(function () {
		// Place your administration-specific JavaScript here

        // TEST form
         jQuery('#adminformsend').click( function() {
                    
                    alert("test form running");
                    var action_url = "fm_update_form";
            		var name    = jQuery('#name').val();
            		var email    = jQuery('#email').val();
            		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              		if(emailReg.test(email))
            		{
                		if(name!="" && email!=""){
                            var formSerial = jQuery("#f_m_input").serialize();
                            alert("running 1");
            				jQuery.ajax(
            					{
            						url: 'http://www.test-sw2.com/wp35/wp-admin/admin-ajax.php',
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    data: jQuery("#f_m_input").serialize() + "&action=" + action_url,
                                    success: function(result) 
            						{
            						//alert("end of update Form " + result);
                       				jQuery('#f_m_resp_data').html(result);
            						}
            					}
            				);
            				return false;
            			}
            		}
		
	     });
        
        // trigger for dropdown (choice of service provider)
        
         jQuery('#fac_provider_profession').live("change", function(event) {
            
            //event.preventDefault();
			var action_url = "fm_get_provider"; 
            //var href = jQuery(this).attr('href'); fm_get_provider
			var href = jQuery(this).val(); 
            //var fm_test = jQuery(event.target.attr('href')); 
            alert("this is the id " + href);
            //var test2 = jQuery("#fac_provider_profession").serialize();
			//alert (test2);
			//alert(result); 
					//var formSerial = jQuery("#fac_provider_profession").serialize();
                            alert("running");
            				jQuery.ajax(
            					{
            						url: 'http://www.test-sw2.com/wp35/wp-admin/admin-ajax.php',
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "fm_id=" + href + "&action=" + action_url,
                                    success: function(result) 
            						{
									//alert("end of send " + result);
									jQuery('#f_m_edit_form').empty();	
									jQuery('#f_m_edit_form').append(result);	
									//die();	
            						//alert("end of update Form " + result);
                       				//jQuery('#f_m_resp_data').html(result);
            						}
            					}
            				); 
            
             
         });    
        
            
        
        
        
        
	});
}(jQuery));