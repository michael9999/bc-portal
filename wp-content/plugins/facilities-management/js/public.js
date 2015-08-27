(function ($) {
	"use strict";
	$(function () {
		// Place your administration-specific JavaScript here
//alert (myAjax.ajaxurl);
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
            						url: myAjax.ajaxurl,
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
		
		// TRIGGER : search by profession
        
         jQuery('#fac_provider_profession').live("change", function(event) {
            
            //event.preventDefault();
			var action_url = "fm_get_provider_profession"; 
            //var href = jQuery(this).attr('href'); fm_get_provider
			var href = jQuery(this).val(); 
            //var fm_test = jQuery(event.target.attr('href')); 
           
            //alert("this hello is the id " + href);
           
            //var test2 =
           jQuery("#fac_provider_profession").serialize();
			//alert (test2);
			//alert(result); 
					//var formSerial = jQuery("#fac_provider_profession").serialize();
                            //alert("running");
            				jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "prof_id_gen=" + href + "&action=" + action_url,
                                    success: function(result) 
            						{
									//alert("end of send " + result);
									jQuery('#f_m_edit_form').empty();
									jQuery('#f_m_resp_data').empty();	
										
									jQuery('#f_m_edit_form').append(result);
									jQuery('[name=fac_provider_profession]').val('Search by type');	
									//$('[name=options]').val( '' );	
									//die();	
            						//alert("end of update Form " + result);
                       				//jQuery('#f_m_resp_data').html(result);
            						}
            					}
            				); 
            
             
         });		
		
        
        // trigger for dropdown (choice of service provider)
        
         jQuery('#fac_provider_choose').live("change", function(event) {
            
            //event.preventDefault();
			var action_url = "fm_get_provider"; 
            //var href = jQuery(this).attr('href'); fm_get_provider
			var href = jQuery(this).val(); 
            //var fm_test = jQuery(event.target.attr('href'));
			 
			 // check that "search by provider is not being clicked"
			 
			 if(href=="Search by provider"){
				 
				 //alert("dropdown value is zero");
				 return false;
				 
			 }
			 
			 
            //alert("this is the id " + href);
           
            //var test2 =
           jQuery("#fac_provider_profession").serialize();
			//alert (test2);
			//alert(result); 
					//var formSerial = jQuery("#fac_provider_profession").serialize();
                            //alert("running");
            				jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "fm_id=" + href + "&action=" + action_url,
                                    success: function(result) 
            						{
									//alert("end of send " + result);
									jQuery('#f_m_edit_form').empty();
									jQuery('#f_m_resp_data').empty();	
										
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
			jQuery('#f_m_edit_form').empty();
			jQuery('#f_m_resp_data').empty();
            //alert("new provider clicked");
			//var fac_form_html = "<form class=validate id=createuser name=createuser method=post action=><input type=hidden value=createuser name=action<input type=hidden value=46ad656ebd name=_wpnonce_create-user id=_wpnonce_create-user><input type=hidden value=/wp35/wp-admin/user-new.php name=_wp_http_referer><table class=form-table><tbody><tr class=form-field form-required><th scope=row><label for=user_login>Username <span class=description>(required)</span></label></th></form>";
			
			var action_url = "fm_build_user_add";
			
			//var fm_current_id 
			
			jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "action=" + action_url,
                                    success: function(result) 
            						{
									//alert("end of send " + result);
									//jQuery('#f_m_edit_form').empty();
									//jQuery('#f_m_resp_data').empty();	
									//alert("form function working");	
									jQuery('#f_m_edit_form').append(result);	
									//die();	
            						//alert("end of update Form " + result);
                       				//jQuery('#f_m_resp_data').html(result);
            						}
            					}
            				);
			
			
			//jQuery('#f_m_resp_data').load( "http://www.test-sw2.com/wp35/wp-content/plugins/facilities-management/views/form.php" );;				
            
             
         });

  // DELETE DOCS (Service provider)
	
		jQuery('#fm_delete_doc').live("click", function(event) {
            
            event.preventDefault();
			
            //alert("delete doc clicked");
			
			var fm_id_new = jQuery(event.target).attr('class');
			
			//alert(fm_id_new);
			
			// check current provider ID
			
			var fm_current_id = jQuery('#fac_provider_choose').val();
			
			//alert("current id is " + fm_current_id);
			
			// define function 
			
			var action_url = "fm_delete_doc";
			
			
			jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "doc_id=" + fm_id_new + "&action=" + action_url +"&prov_id=" + fm_current_id,
                                    success: function(result) 
            						{
									
									jQuery('#f_m_resp_data').empty();	
									//alert("doc deleted " + result);
									jQuery('#f_m_edit_form').empty();
									
									// $_POST['doc_id']	
									jQuery('#f_m_edit_form').append(result);	
									
            						}
            					}
            				); 
			
			
			
             
         });		

// Add new profession 
	
		jQuery('#fm_prof_add').live("click", function(event) {
            
            event.preventDefault();
			//jQuery('#f_m_edit_form').empty();
			//jQuery('#f_m_resp_data').empty();
			var prof_val = jQuery("#fm_prof_type").val();
			
            //alert("new provider clicked" + prof_val);
			
			// ADD TO DATABASE
			
			
			var action_url = "fm_add_prof";
			
			
			jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "prof_name=" + prof_val + "&action=" + action_url,
                                    success: function(result) 
            						{
									
									//alert("doc deleted " + result);
									jQuery('#fm_profession_results').empty();
									//jQuery('#f_m_resp_data').empty();	
									// $_POST['doc_id']	
									jQuery('#fm_profession_results').append(result);	
									
            						}
            					}
            				); 
			
            
             
         });
		
// Show all profession 
	
		jQuery('#fm_prof_show_all').live("click", function(event) {
            
            event.preventDefault();
			
			
			// ADD TO DATABASE
			var prof_val = jQuery("#fm_prof_type").val();
			
			var action_url = "fm_show_all_prof";
			
			
			jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						
									data: "prof_name=" + prof_val + "&action=" + action_url,
                                    success: function(result) 
            						{
									
									
									jQuery('#fm_profession_results').empty();
						
									jQuery('#fm_profession_results').append(result);	
									
            						}
            					}
            				); 
			
            
             
         });		
		

// Delete profession
		
		
		// Add new profession 
	
		jQuery('#f_m_prof_delete').live("click", function(event) {
            
            event.preventDefault();
			
			var fm_prof_delete_id = jQuery(event.target).attr('href');
			
            //alert("ID is " + fm_prof_delete_id);
			
			var action_url = "fm_prof_delete";
			
		// DELETE FROM DATABASE
			
			jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "prof_del_id=" + fm_prof_delete_id + "&action=" + action_url,
                                    success: function(result) 
            						{
									
									//alert("doc deleted " + result);
									jQuery('#fm_profession_results').empty();
									//jQuery('#f_m_resp_data').empty();	
									// $_POST['doc_id']	
									jQuery('#fm_profession_results').append(result);	
									
            						}
            					}
            				); 
			
			
            
             
         });
		
		
// View provider from profession results
		
		
		
	
		jQuery('#view_prov_id').live("click", function(event) {
            
            event.preventDefault();
			
			var fm_prof_view_id = jQuery(event.target).attr('class');
			
            //alert("ID is " + fm_prof_delete_id);
			
			var action_url = "fm_get_provider";
			
		
			
			jQuery.ajax(
            					{
            						url: myAjax.ajaxurl,
            						type: 'POST',
            						//data: "name=" + name + "&email=" + email + "&action=" + action_url,
            						//data: "formSerial=" + formSerial + "&action=" + action_url,
                                    //data: jQuery("#fac_provider_profession").serialize() + "&action=" + action_url,
									data: "fm_id=" + fm_prof_view_id + "&action=" + action_url,
                                    success: function(result) 
            						{
									
									//alert("doc deleted " + result);
									jQuery('#fm_profession_results').empty();
									jQuery('#f_m_edit_form').empty();	
										
									//jQuery('#f_m_resp_data').empty();	
									// $_POST['doc_id']	
									jQuery('#f_m_edit_form').append(result);	
									
            						}
            					}
            				); 
			
			
            
             
         });		
		
		
		
// end delete		
        
	});
}(jQuery));