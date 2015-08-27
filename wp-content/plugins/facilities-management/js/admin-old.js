(function ($) {
	"use strict";
	$(function () {
		// Place your administration-specific JavaScript here

            // test for submit button
            
            jQuery( "#f_m_user_submit" ).click(function(event) {
                 
              //jQuery("#f_m_input").validate();
             event.preventDefault();
            
            // Validation first text box
            
            if (jQuery('#f_m_user').val() == '') {
            //errors.push('<li>please enter your article body</li>');
            //valid = false;
            jQuery("label[for='f_m_user']").text("This field is required");
            jQuery('#f_m_user').css( "border", "red 1px solid" );
            alert("field is empty");
            return false;
            }
            
            else if(jQuery('#f_m_field2').val() == ''){
                
              if (jQuery('#f_m_field2').val() == '') {
            //errors.push('<li>please enter your article body</li>');
            //valid = false;
            jQuery("label[for='f_m_field2']").text("This field is required");
            jQuery('#f_m_field2').css( "border", "red 1px solid" );
            alert("field is empty");
            return false;
            }  
                
                
                
            }
            
            else{
                
                jQuery("label[for='f_m_user']").text(" ");
                jQuery('#f_m_user').css( "border", "green 1px solid" );
                
                jQuery("label[for='f_m_field2']").text(" ");
                jQuery('#f_m_field2').css( "border", "green 1px solid" );
            
                
            }
              
            
            
            
            
        updateContact();
    

             
              // Run function h
        
            
              
            });
        
        // Data validation for test form
        
         
        
            
        // TRIAL: SEND TO DATABASE 
        
        function updateContact(){
            
                   alert("SERAILISE PLEASE");
                
                // get data from form
                
                //var lid2 = jQuery('form').find('input[type=text],textarea').filter(':visible:first').attr('id');
                //var lid3 = jQuery('form').find('input[type=text],textarea').filter(':visible:first').val();               
                
                var formSerial = jQuery("#f_m_input").serialize();
                
                alert("serialsed data: " + formSerial);
                
                alert("what's in this string? " + formSerial);
                
                var data = {
                    
                    action: 'fm_update_form',
                    varTrial: formSerial,
                    
                    
                };
                
                // set admin url fm_update_form fm_update_form
                
                alert("just before ajax call");
                    
                jQuery.post('http://www.test-sw2.com/wp35/wp-admin/admin-ajax.php', data, function(resp){
                
                //jQuery.post(myAjax.ajaxurl, data, function(resp){
                  
                   
                   alert("end of update Form " + resp);
                   jQuery('#f_m_resp_data').html(resp);
                   
                    
                });
            
            
            
            
                } 
        
        
        
	});
}(jQuery));