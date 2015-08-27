(function ($) {
	"use strict";
	$(function () {
		// Place your administration-specific JavaScript here
alert (myAjax.ajaxurl);
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
        
  // Create new provider 
	
		jQuery('#fac_new_provider').live("click", function(event) {
            
            event.preventDefault();
			
            alert("new provider clicked");
			//var fac_form_html = "<form class=validate id=createuser name=createuser method=post action=><input type=hidden value=createuser name=action<input type=hidden value=46ad656ebd name=_wpnonce_create-user id=_wpnonce_create-user><input type=hidden value=/wp35/wp-admin/user-new.php name=_wp_http_referer><table class=form-table><tbody><tr class=form-field form-required><th scope=row><label for=user_login>Username <span class=description>(required)</span></label></th></form>";
			jQuery('#f_m_resp_data').load( "http://www.test-sw2.com/wp35/wp-content/plugins/facilities-management/views/form.html" );;				
            
             
         });
  
// Send button for create new service provider


		//jQuery('#fm_create_user').live("click", function(event) {
            
          //  event.preventDefault();
			
          //  alert("Add new provider clicked");
			
			// Send to script for user creation
             
         // });		
		
// trial: send uploaded docs
		
jQuery("form").live("submit", function(e)
{
 	e.preventDefault();
	alert("form running");
    var formObj = jQuery(this);
    var formURL = formObj.attr("action");
    var formData = new FormData(this);
    jQuery.ajax({
        url: formURL,
    type: 'POST',
        data:  formData,
    mimeType:"multipart/form-data",
    contentType: false,
        cache: false,
        processData:false,
    success: function(data, textStatus, jqXHR)
    {
 		$("#f_m_resp_data").html('<pre><code>'+data+'</code></pre>');
    },
     error: function(jqXHR, textStatus, errorThrown) 
     {
		 $("f_m_resp_data").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
     }          
    });
    //e.preventDefault(); //Prevent Default action.
	
});
 
//$("#multiform").submit(); //Submit the form


		
		
		
  // end create new provider      
        
        
	});
}(jQuery));