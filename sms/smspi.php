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

$number = $_REQUEST['from'];
$message = $_REQUEST['message'];
include ($smsfile);

?>