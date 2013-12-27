<?php
######################################################
#        RPI Control By Robert Wiggins				 #
#													 #
# http://www.github.com/txt3rob/RPI-Control/		 #
#													 #
#        Donate to txt3rob@gmail.com 				 #
#													 #
######################################################

include ('config.php');
include ('main.php');

if (!empty($_POST['id'])) {
exit();	
}

//Look for commands	
$url =  $_POST["id"];
echo $url;

exit(); die();

// is it an on or off command?
if (strpos($url,'-') !== false) {
$parts = explode("-", $url);
$dev = $parts[0];
$onoroff = $parts[1];


// Set on or off state
if ($onoroff == "on") {
$state = "1";
} else {
$state = "0";
}

// Find Device in DB
$devlookup = $dbh->prepare("SELECT * FROM `devices` WHERE `name` = :name");
$devlookup = bindParam(':name', $dev);
$devlookup->execute();
$devlookup->fetch(PDO::FETCH_ASSOC);
$brand = $devlookup['brand'];
$remote = $devlookup['remote'];
$channel = $devlookup['channel'];

// execute command and update the state in DB
commandit ($brand,$remote,$channel,$state);
updatestate ($dev,$state);
}










?>
