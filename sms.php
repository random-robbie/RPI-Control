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
include ('functions.php');

GLOBAL $number;
GLOBAL $message;

// Does user have permission
$permission = $dbh->prepare("SELECT * FROM `users` WHERE `number` = :number");
$permission->bindParam(':number', $number);
$permission->execute();
$permish = $permission->fetch(PDO::FETCH_ASSOC);
$user = $permish['name'];
$count = $permission->rowCount();
if ($count == "0")
{
echo "Permission Denied";
exit ();
}

// Record who sent the message
insertsms ($user,$message);


// Seperate Message
$comm = explode( ' ', $message );
$dev=$comm[0];
$onoroff=$comm[1];





//Is it a wake on lan request?
if ($dev == "wol")
{
wol ($onoroff);
updatehistory ($message,$user);
exit();
}

$on = strtoupper($onoroff);
// Set on or off state
if ($on == "ON") {
$state = "1";
} else {
$state = "0";
}





// Find Device in DB
$devlookup = $dbh->prepare("SELECT * FROM `devices` WHERE `name` = :name");
$devlookup->bindParam(':name', $dev);
$devlookup->execute();
$count = $devlookup->rowCount();
if ($count == "0") {
echo "No Device with ".$dev." has been found in the Database";
exit();
}
$devlookup2 = $devlookup->fetch(PDO::FETCH_ASSOC);
$brand = $devlookup2['brand'];
$remote = $devlookup2['remoteid'];
$channel = $devlookup2['channel'];




// execute command
commandit ($brand,$remote,$channel,$state);
// Update the Web Interface
updatestate ($dev,$state);
//Update SMS History
updatehistory ($message,$user);
?>
