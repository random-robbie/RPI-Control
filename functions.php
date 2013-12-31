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
$filepath = dirname(dirname(__FILE__));

$uptime = shell_exec("cut -d. -f1 /proc/uptime");
				$days = floor($uptime/60/60/24);
				$hours = $uptime/60/60%24;
				$mins = $uptime/60%60;
				


//List Devices
$devices = $dbh->prepare("SELECT * FROM `devices`");
$devices->execute();

//List Users
$users = $dbh->prepare("SELECT * FROM `users`");
$users->execute();

//List wol
$wollist = $dbh->prepare("SELECT * FROM `wol`");
$wollist->execute();

function updatestate ($dev,$state)
{
// update database with state
GLOBAL $dbh;
$updatestate = $dbh->prepare("UPDATE `devices` SET  `state` = :state WHERE `name` = :name");
$updatestate ->bindParam(':name', $dev);
$updatestate ->bindParam(':state', $state);
$updatestate->execute();
}

function commandit ($brand,$remote,$channel,$state)
{
// execute command
passthru ('sudo pihat --brand='.$brand.' --repeats=15 --id='.$remote.' --channel='.$channel.' --state='.$state.'');
}

function insertsms ($user,$message)
{
GLOBAL $dbh;
$insertsms = $dbh->prepare ("INSERT INTO smshistory (user,command) VALUES (:user,:message)");
$insertsms->bindParam(':user', $user);
$insertsms->bindParam(':message', $message);
$insertsms->execute();
}

function updatehistory ($command,$user)
{
GLOBAL $dbh;
$updatehistory = $dbh->prepare("UPDATE `smshistory` SET  `completed` = 1 WHERE `command` = :command AND `user` = :user ");
$updatehistory->bindParam(':command', $command);
$updatehistory->bindParam(':user', $user);
$updatehistory->execute();
}

function wol ($computer)
{
GLOBAL $dbh;
$wol = $dbh->prepare("SELECT * FROM `wol` WHERE computer = :computer");
$wol->bindParam(':computer', $computer);
$wol->execute();
$count = $wol->rowCount();
if ($count == "0") {
echo "No Computer with that name found";
exit();
}
$wol2 = $wol->fetch(PDO::FETCH_ASSOC);
$mac = $wol2['mac'];
passthru ('wakeonlan '.$mac.'');
echo "Wake on Lan Command Sent";
}

function add_device ($devicename,$devicebrand,$deviceremoteid,$devicechannel) {
GLOBAL $dbh;
include('config.php');
$checkdev = $dbh->prepare("SELECT * FROM `devices` WHERE (`channel` = :channel OR `name` = :name)");
$checkdev->bindParam(':channel', $devicechannel);
$checkdev->bindParam(':name', $devicename);
$checkdev->execute();
$count = $checkdev->rowCount();

if ($count > 0) {
echo "Device with the same name or channel number already exists";
} else {
$insertdev = $dbh->prepare("INSERT INTO `devices` (`name`, `brand`, `remoteid`, `channel`, `state`) VALUES (:name, :brand, :remote, :channel, 0)");
$insertdev->bindParam(':name', $devicename);
$insertdev->bindParam(':brand', $devicebrand);
$insertdev->bindParam(':remote', $deviceremoteid);
$insertdev->bindParam(':channel', $devicechannel);
$insertdev->execute();
echo "<br><b>Device Added to Database</b><br />";
}
}

function addmac ($name,$mac) {
GLOBAL $dbh;
$checkmac = $dbh->prepare("SELECT * FROM `wol` WHERE (`computer` = :computer OR `mac` = :mac)");
$checkmac->bindParam(':computer', $name);
$checkmac->bindParam(':mac', $mac);
$checkmac->execute();
$countmac = $checkmac->rowCount();

if ($countmac > 0) {
echo "Computer name or mac already in database";
} else {

$insertmac= $dbh->prepare("INSERT INTO `wol` (`computer`, `mac`) VALUES (:computer, :mac)");
$insertmac->bindParam(':computer', $name);
$insertmac->bindParam(':mac', $mac);
$insertmac->execute();
echo "<br><b>WOL Added to Database</b><br />";
}
}
function adduser ($name,$number) {
GLOBAL $dbh;
$checkuser = $dbh->prepare("SELECT * FROM `users` WHERE (`number` = :number OR `name` = :name)");
$checkuser->bindParam(':name', $name);
$checkuser->bindParam(':number', $number);
$checkuser->execute();
$countuser = $checkuser->rowCount();

if ($countuser > "0") {
echo "User or Number already in database";
} else {
$insertuser= $dbh->prepare("INSERT INTO `users` (`name`, `number`) VALUES (:name, :number)");
$insertuser->bindParam(':name', $name);
$insertuser->bindParam(':number', $number);
$insertuser->execute();
echo "<br><b>User Added to Database</b><br />";
}
}

function uptime ()
{
$data = shell_exec('uptime');
  $uptime = explode(' up ', $data);
  $uptime = explode(',', $uptime[1]);
  $uptime = $uptime[0];

  echo ('Current server uptime: '.$uptime.'
');
}

function removeuser ($name) {
GLOBAL $dbh;
GLOBAL $configfile;
include($configfile);
$remuser = $dbh->prepare("DELETE FROM `users` WHERE `name` = :name");
$remuser->bindParam(':name', $name);
$remuser->execute();
echo "User Removed";
}

function removewol ($comp) {
GLOBAL $dbh;
GLOBAL $configfile;
include($configfile);
$remwol = $dbh->prepare("DELETE FROM `wol` WHERE `computer` = :computer ");
$remwol->bindParam(':computer', $comp);
$remwol->execute();
echo "Wol Removed";
}

function removedevice ($device) {
GLOBAL $dbh;
GLOBAL $configfile;
include($configfile);
$remdev = $dbh->prepare("DELETE FROM `devices` WHERE `name` = :name ");
$remdev->bindParam(':name', $device);
$remdev->execute();
echo "".$device." has been removed.";
}

function refreshpage ($url) {
header('Location: '.$url.'');
}

function allon() {
GLOBAL $devices;

foreach ($devices as $device){
$dev = $device['name'];
$brand = $device['brand'];
$remote = $device['remoteid'];
$channel = $device['channel'];
$state = "1";

// execute command and update the state in DB
commandit ($brand,$remote,$channel,$state);
updatestate ($dev,$state);
}
}

function alloff() {
GLOBAL $devices;

foreach ($devices as $device){
$dev = $device['name'];
$brand = $device['brand'];
$remote = $device['remoteid'];
$channel = $device['channel'];
$state = "0";

// execute command and update the state in DB
commandit ($brand,$remote,$channel,$state);
updatestate ($dev,$state);
}
}

?>