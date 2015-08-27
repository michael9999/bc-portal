<?php
 if(isset($_POST['fm_add']))
 {
     
     // ADD NEW USER, DO NOT SEND PASSWORD
	 
	 $_POST['captcha']=preg_replace('/\s+/', '', $_POST['captcha']);

    // convert to lower case
    $captcha = strtolower($_POST['captcha']);
    
    if($captcha == "chelsea"){
	 
	 
	 
	 if( null == email_exists( $_POST['email'] ) ) {

  
  
             /* echo "<p>your account has been created, please note that your username will always be the email address you
              entered on the previous page. You will receive your password by email. </p>";
              
              echo "<a href='http://www.test-sw2.com/facilities/form-1/'>Start the survey</a>";*/
              


              
              
            		 
            } // end if


// IF email or username is already taken ask user to choose a new address. 

    else{
        
              // show form again
        
        echo "<p>It appears that an account already exists under that email address,
        please login below.</p>
        
        <p>If you don't remember your password please click here: <a href='http://www.test-sw2.com/facilities/wp-login.php?action=lostpassword' title='Password Lost and Found'>
        Password reset</a>, you'll then receive an email with a link to reset it.</p>";
        
        ?>
	
<form name="loginform" id="loginform" action="http://www.test-sw2.com/facilities/wp-login.php" method="post">
	<p>
		<label for="user_login">Username:<br />
		<input type="text" name="log" id="user_login" class="input" value="" size="20" /></label>
	</p>
	<p>
		<label for="user_pass">My Password:<br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" /></label>
	</p>
	<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"  /> Remember Me</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In" />
		<input type="hidden" name="redirect_to" value="http://www.test-sw2.com/facilities/wp-admin/" />
		<input type="hidden" name="testcookie" value="1" />
	</p>
</form>

<p id="nav">
<!--<a href="http://www.test-sw2.com/facilities/wp-login.php?action=register">Register</a> | -->
<a href="http://www.test-sw2.com/facilities/wp-login.php?action=lostpassword" title="Password Lost and Found">Lost your password?</a>
</p><?php
        
        
               
      
        }


}

// if recaptcha is not correct 

else{
    
    echo "<p> You didn't provide the correct answer to the anti-spam question: <b>Chelsea</b> are in fact the <b>best</b> team in the Premiership!
    please try again or contact us on 0149557364 for help:)</p>

<form class='validate' id='fm_createuser' name='fm_createuser' method='post' enctype='multipart/form-data' action=''>


<input type='hidden' value='fm_add' class='code' id='fm_add' name='fm_add'>

<div id='email-wrap'><label for='email' id='label-email'>Email</label><br><br>    
<input type='text' value='' id='email' name='email' required></div>

<div id='email-wrap'><label for='captcha' id='label-captcha'>Who are the best team in the English Premier league? (antispam)</label><br><br>    
<input type='text' value='' id='captcha' name='captcha' required></div>

<p class='submit'><input type='submit' value='Get started! ' class='button button-primary' id='sub' name='createuser'></p>
</form>"; 
    
    
}


// end recaptcha


}

// show sign-up form if this is the 1st time user has visited the page


else{
    
echo "<p>Please use the form below to sign up for the site, you'll then receive a password (possible to change later) 
and gain access to the rest of FM information site.

<form class='validate' id='fm_createuser' name='fm_createuser' method='post' enctype='multipart/form-data' action=''>


<input type='hidden' value='fm_add' class='code' id='fm_add' name='fm_add'>

<div id='email-wrap'><label for='email' id='label-email'>Email</label><br><br>   
<input type='text' value='' id='email' name='email' required></div>

<div id='email-wrap'><label for='captcha' id='label-captcha'>Who are the best team in the English Premier league? (antispam)</label><br><br>    
<input type='text' value='' id='captcha' name='captcha' required></div>

<p class='submit'><input type='submit' value='Get started! ' class='button button-primary' id='sub' name='createuser'></p>
</form>";    
    
    
}





?>