<?php
######################################################
#        RPI Control By Robert Wiggins				 #
#													 #
# http://www.github.com/txt3rob/RPI-Control/		 #
#													 #
#        Donate to txt3rob@gmail.com 				 #
#													 #
######################################################
$current2 = getcwd();
$current = str_replace('sms', '', $current2);
$smsfile = "".$current."sms.php";

// Grab Posted Data from textlocal
$number2 = $_REQUEST['sender'];
$message2 = $_REQUEST['content'];

// Your Text Local Keyword ensure you add space after the keyword
$smskey = " ";

// Convert 44 sender to 0
$ptn = "/^44/";  
$rpltxt = "0";
$number = preg_replace($ptn, $rpltxt, $number2);

// Remove keyword 
$message = str_replace($smskey, "", $message2);

//SMS file to deal with the message
include ($smsfile);


?>
