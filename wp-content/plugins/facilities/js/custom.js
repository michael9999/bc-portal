jQuery(document).ready(function($) {
   
   var select = document.getElementsByTagName("SELECT")[0];
   select.selectedIndex = 0;
   
   //alert("js custom file is running");
   
   jQuery('#fac_contact').on('change', function() {
     
    var id = $(this).children(":selected").attr("id");
    //alert(id);
    
    getAllContactInfo(id);
    
   
    });

//*********** CONTACTS: TRIGGER FOR EDIT CONTACT *****************


    jQuery("a.cont-edit").live('click', function (event) {
                   
                   alert("link clicked " + event.target.id);
                   event.preventDefault();
                   var lid = event.target.id;
                   alert(lid);
                   
                   getEditForm(lid);
                    
                });
   
//************* CONTACT: trigger for edit contact form *****

 jQuery(".cont-edit-submit").live('click', function (event) {
                   
                   alert("link clicked " + event.target.id);
                   event.preventDefault();
                   //var lid2 = event.target.id;
                   
                   //var lid2 = jQuery('form').find('input[type=text],textarea').filter(':visible:first').val();
                   
                   //var lid2 = jQuery('form').find('input[type=text],textarea').filter(':visible:first').attr('id');
                   
                   //alert("this is the entry's ID value" + lid2);
                   
                   var newData = jQuery(this).serialize();
                   
                   updateContact(newData);
                    
                });
    
//**************** CONTACTS: GET ALL CONTACT DETAILS ****************

    function getAllContactInfo(contact_id){

        alert("entry ID " + contact_id);
    
    var data = {
        
        action: 'fac_get_all_contact',
        identifier: contact_id,
        
        
    };
    
    jQuery.post('http://www.test-sw2.com/facilities/wp-admin/admin-ajax.php', data, function(resp){
       
       // process data returned
       alert("end of get all service provider info " + resp);
       jQuery('#fac-contact-data').html(resp);
       //$('.result').html(data);
        
    });



    }

 //**************** CONTACTS: FUNCTION display edit form ****************

    function getEditForm(contact_id){

        alert("inside getEdit Form, entry ID = " + contact_id);
    
    var data = {
        
        action: 'fac_get_edit_form',
        identifier: contact_id,
        
        
    };
    
    jQuery.post('http://www.test-sw2.com/facilities/wp-admin/admin-ajax.php', data, function(resp){
       
       // process data returned
       alert("end of get getEdit Form " + resp);
       jQuery('#fac-contact-data').html(resp);
       //$('.result').html(data);
        
    });



    }


 //**************** CONTACTS: FUNCTION Update entry in db ****************

    function updateContact(contact_id){

       alert("SERAILISE PLEASE = " + contact_id);
    
    // get data from form
    
    var lid2 = jQuery('form').find('input[type=text],textarea').filter(':visible:first').attr('id');
    var lid3 = jQuery('form').find('input[type=text],textarea').filter(':visible:first').val();               
    
    var stringTrial;
    
    /*jQuery("#cont-edit-form input[type=text]").each(function() {

                
                    alert(this.value + " is an entry");
                    //stringTrial += this
                

            });*/
    
    // attempt to serialise wholeform 
    
    //var formSerial = jQuery("#cont-edit-form :input[value]").serialize();
    
    var formSerial = jQuery("cont-edit-form").serialize();
    
    alert("serialsed data: " + formSerial);
    
    /*jQuery.each($('#cont-edit-form').serializeArray(), function() {             
            stringTrial += (" <" +this.name+ '>' + this.value + "</"  + this.name + "> " );      
        });*/
    
    alert("what's in this string? " + formSerial);
    
     //var newValue1 = jQuery("#Insurance").val();
     //var newValueID = jQuery("#Insurance").attr('id');
    
    //.attr('value')
    
     alert("inside getEdit Form, META ID VALUE = " + lid2 + " " + lid3);
    
    var data = {
        
        action: 'fac_update_contact',
        identifier: contact_id,
        var1: lid3,
        var1id: lid2,
        varTrial: formSerial,
        
        
    };
    
    jQuery.post('http://www.test-sw2.com/facilities/wp-admin/admin-ajax.php', data, function(resp){
       
       // process data returned
       alert("end of update Form " + resp);
       jQuery('#fac-contact-data').html(resp);
       //$('.result').html(data);
        
    });




    }  
 

});


