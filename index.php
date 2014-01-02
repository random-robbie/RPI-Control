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

if(empty($_GET)) 
    exit();


//Look for commands	
$url =  $_GET["id"];
// is it an on or off command?
if (strpos($url,'-') !== false) {
$parts = explode("-", $url);
$dev = $parts[0];
$onoroff = $parts[1];

if ($url == "all-on") {
include('functions.php');
allon();
exit();
}

if ($url == "all-off") {
include('functions.php');
alloff();
exit();
}

// Set on or off state
if ($onoroff == "on") {
$state = "1";
} else {
$state = "0";
}




// Find Device in DB
GLOBAL $dbh;
$devlookup = $dbh->prepare("SELECT * FROM `devices` WHERE `name` = :name");
$devlookup->bindParam(':name', $dev);
$devlookup->execute();
$count = $devlookup->rowCount();
if ($count < "1"){
$devid = $devlookup->fetch(PDO::FETCH_ASSOC);
$brand = $devid['brand'];
$remote = $devid['remoteid'];
$channel = $devid['channel'];



// execute command and update the state in DB
commandit ($brand,$remote,$channel,$state);
updatestate ($dev,$state);
} else {
include ('functions.php');
wol ($dev);
}
}










?>
