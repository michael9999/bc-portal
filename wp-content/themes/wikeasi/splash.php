<?php
/*
Template Name: Splash
*/
//require_once('mobile_device_detect.php');
//mobile_device_detect(true,false,true,false,true,true,true,'http://www.cv-en-anglais.com/?theme=bp-mobi',false);
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Facilities Management portal, BC Paris</title>
	<meta name="description" content="How to create a simple two column CSS layout with full width header and footer.">
	<meta name="copyright" content="Copyright (c) 2004 Roger Johansson">
	<meta name="author" content="Roger Johansson">
	<style type="text/css" media="screen, print, projection">

body, html {

    /* background-image: url("http://www.cv-en-anglais.com/wp-content/themes/frisco-for-buddypress/images/blue1.png");*/
    background-position: 10% -100%;
    background-repeat: no-repeat;

     color: #000000;
     margin: 0px;
     padding: 0px;
}


#wrap2{

width: 100%;
background-color: white;
border-bottom: 1px solid #CCCCCC;


}



#wrap {


     background-attachment: scroll;
     background-clip: border-box;
     
     background-origin: padding-box;
     background-position: 0% 0%;
     background-repeat: repeat;
     background-size: auto auto;
     margin: 0px auto;
     width: 100%;
}

#header {
     background: none repeat scroll 0% 0% white;
     height: 20%;
     padding: 5px 10px;
}


span#intro-text-title{

	color: #666666;
    	font-size: 22px;
    	line-height: 25px;
	font-family: Helvetica;
    	font-weight: 100;

}

p#intro-text{


	font-family: Helvetica;
   	 font-weight: 100;

	font-size: 16px;

	width: 100%;

	line-height: 24px;

	color: #666666;


}


h1 {
     margin: 0px;
}

h1#cv-title1 {
     margin-left: 23.5%;
     margin-top: 3%;
     font-family: Helvetica;
     
}

#nav {
     background: none repeat scroll 0% 0% white;
     
     padding: 0px 10px;
}

#nav2 {
     background: none repeat scroll 0% 0% transparent;
     padding: 5px 10px;
}

#nav3 {
     background: none repeat scroll 0% 0% transparent;
     margin-top: 2%;
}

#nav ul {
    list-style: none outside none;
    margin-bottom: 0.5%;
    margin-left: auto;
    margin-right: auto;
    padding: 0;
    text-align: right;
    width: 960px;
}


#nav ul li a{
     

    border: 0px solid #CCCCCC;
    border-radius: 0 3px 3px 3px;
    color: #666666;
    font-size: 13px;
    padding: 0px 10px;
    text-decoration: none;
	font-family: Helvetica;


}

#nav ul li a:hover{
     

    border: 0px solid #005DAB;
    border-radius: 0 3px 3px 3px;
    color: #005DAB;
    font-size: 13px;
    padding: 0px 10px;
    text-decoration: none;
	font-family: Helvetica;

}


#nav li {
     display: inline;
     margin: 0px;
     padding: 0px;
}

#main {
     background: none repeat scroll 0% 0% white;
     float: left;
     padding: 10px;
     width: 50%;
}

#main-full {
     background-color: white;
     width: 100%;
}

#main-0 {
     background-color: white;
     border: 1px solid #E2E2E2;
     left: 20%;
     padding: 5px;
     position: relative;
     width: 960px;
}

#main2 {
     background: none repeat scroll 0% 0% white;
     margin-left: 0%;
     margin-top: 0%;
     padding: 10px;
     position: relative;
     width: auto;
}

h2 {
     margin: 0px 0px 1em;
}

#sidebar {
     background: none repeat scroll 0% 0% white;
     float: right;
     left: -6%;
     margin-top: 0%;
     padding: 10px;
     position: relative;
     width: 40%;
}

#sidebar2 {
     background: none repeat scroll 0% 0% white;
     padding: 10px;
     position: relative;
     width: 40%;
margin-top: 6%;	

}

#footer {
     background: none repeat scroll 0% 0% white;
     clear: both;
     padding: 5px 10px;


}

#footer p {
     margin: 0px;
}

* html #footer {
     height: 1px;
}

#logo {
    margin-bottom: -2%;
    margin-left: 20%;
    margin-top: 15px;
}



#translate-1{

background: -moz-linear-gradient(center top , #009BF6 0%, #0079C1 100%) no-repeat scroll 95% 50% transparent;
    border-color: #00588B;
    border-radius: 10px 10px 10px 10px;
    border-style: solid;
    border-width: 1px;
    color: white;
    cursor: pointer;
    font-size: 15px;
    font-weight: bold;
    line-height: 21px;
    padding: 12px;
    text-decoration: none;
    text-shadow: 0 0px rgba(255, 255, 255, 0.75);
font-family: Helvetica;
position: relative;
margin-left: 20px;

}

#translate-1:hover{

background: -moz-linear-gradient(center top , #007FC9 0%, #005282 100%) no-repeat scroll 95% 50% transparent;
    border-color: #00588B;
    border-style: solid;
    border-width: 1px;
    color: white;
text-shadow: 1 1px rgba(255, 255, 255, 0.75);
}



#get-started1{

background: -moz-linear-gradient(center top , #99C43C 0%, #82B710 100%) no-repeat scroll 95% 50% transparent;
    border-color: #656565;
    border-radius: 10px 10px 10px 10px;
    border-style: solid;
    border-width: 1px;
    color: white;
    cursor: pointer;
    font-size: 15px;
    font-weight: bold;
    line-height: 21px;
    padding: 12px;
    text-decoration: none;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
font-family: Helvetica;
position: relative;
width: 20%;
margin: auto;
text-align: center;
}

#get-started1 a{

color: white;
text-decoration: none;
text-align: center;

}

#get-started1:hover{

background: -moz-linear-gradient(center top , #729A1D 0%, #729A1D 100%) no-repeat scroll 95% 50% transparent;
    border-color: #656565;
    border-style: solid;
    border-width: 1px;
    color: white;
text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);

}



#main3 {
    margin-bottom: 2%;
    margin-left: 2%;
    margin-top: 0;
}



/* footer styling */


#footer-elements ul{

list-style-type: none;
margin: 1%;
padding: 0;
font-family: helvetica;
font-size: 12px;
text-align: right;


}


#footer-elements ul li{

list-style-type: none;
padding: 0;
display: inline-block;


}

#footer-elements ul li a{


list-style-type: none;
padding-left: 10px;
padding-right: 10px;
display: inline-block;
color: #005DAB;


}


#footer-elements ul li a:hover{


list-style-type: none;
padding-left: 10px;
padding-right: 10px;
display: inline-block;
color: #666666;


}


#footer-elements{

margin-bottom: -1%;
margin-top: -1%;
color: #666666;

}


/* CHROME */



@media screen and (-webkit-min-device-pixel-ratio:0) {


	#translate-1{

		background-color:  #009BF6;

	}

	#translate-1:hover{

		background-color: #007FC9;
    
	}


	#get-started1{

   		background-color: #82AC27;

	}

	#get-started1:hover{

		background-color: #729A1D;
    
	}

    #wp-submit{
    
        background-color:  #009BF6;
    
    }


    #wp-submit:hover{
    
        background-color: #007FC9;
    
    }


}

/* login form */

#loginform-custom{

margin-top: -15%;
margin-left: 5%;

}




#loginform-custom input[type="text"]{

border: 1px solid black;
font-size: 16px;
font-family: Helvetica;
height: 30px;
color: #666666;

}

#loginform-custom input[type="password"]{

border: 1px solid black;
font-size: 16px;
font-family: Helvetica;
height: 30px;
color: #666666;

}

#loginform-custom label{

font-size: 16px;
font-family: Helvetica;
color: #666666;
font-weight: bold;
}

#wp-submit{

   background: -moz-linear-gradient(center top , #009BF6 0%, #0079C1 100%) no-repeat scroll 95% 50% transparent;
    border-color: #00588B;
    border-radius: 10px 10px 10px 10px;
    border-style: solid;
    border-width: 1px;
    color: white;
    cursor: pointer;
    font-family: Helvetica;
    font-size: 20px;
    font-weight: bold;
    height: 40px;
    width: 100px;
    

}

#loginform-custom input[type="submit"]{

color: white;

}


	</style>


</head>
<body>
<div id="wrap">

    <div id="wrap2">

	<div id="header">

<div id="logo"><img src="http://www.test-sw2.com/facilities/wp-content/uploads/2013/02/green-logo3.png" id="logo-cv-anglais"> </div>

<h1></h1>

<div id="nav">
	<	<ul>
			<li></li>
			
			<li></li>
			<li></li>
			
		</ul> 
	</div>


</div>

    </div>

	
<div id="nav2">

	<div id="nav3">


	</div>

</div>

<div id="main-0">

	<div id="main-full">
		
		<!-- <h1 id="cv-title1">  Facilities Management portal for Paris </h1> -->

	</div>

	<div id="main">




		
		
	<div id="main2"> <p id="intro-text">
 <span id="intro-text-title">
Welcome to the Facilities portal </span><br>

Please login if you already have an account or click the link below to register

<br>
</p>
<?php wp_register('<div id=get-started1>', '</div>'); ?><br>

<p id="intro-text">

You'll find all sorts of helpful information here such as :<br><br>

- <b>facilities procedures
<br><br>


- how-to guides
<br><br>


- service provider contact and contractual information </b>
<br><br>

</p>
 </div>

<div id="main3">

<!--
<a href="#" id="get-started1">Inscrivez-vous gratuitement !</a>

<a href="#" id="translate-1">Traduire son CV </a>
-->

</div>


<!-- end of main div -->

	</div>




	<div id="sidebar">
		

<div id="sidebar2"> 
<?php
if ( ! is_user_logged_in() ) { // Display WordPress login form:
    $args = array(
        'redirect' => home_url(),//admin_url(), 
        'form_id' => 'loginform-custom',
        'label_username' => __( 'Username' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in' => __( 'Log In' ),
        'remember' => true,
        
    );
    wp_login_form( $args );
} else { // If logged in:
    wp_loginout( home_url() ); // Display "Log Out" link.
    echo " | ";
    wp_register('', ''); // Display "Site Admin" link.
}
?>

</div>

	</div>

	<div id="footer">
	

<div id="footer-elements"> <ul> <li> Copyright 2013 M. Smuts. Tous droits reserves </li> <!-- <li> | <a href="#"> Contact </a> | </li> --></ul> </div>
	

	</div>

</div>
</div>




</body>
</html>
