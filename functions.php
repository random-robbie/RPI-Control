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
				
$stats = shell_exec('.'.$filepath.'/scripts/stats.sh');

//List Devices
GLOBAL $dbh;
$devices = $dbh->prepare("SELECT * FROM devices");
$devices->execute();

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
$wol2 = $wol->fetch(PDO::FETCH_ASSOC);
$mac = $wol2['mac'];
passthru ('wakeonlan '.$mac.'');
echo "Wake on Lan Command Sent";
}
function addevice ($devicename,$devicebrand,$deviceremoteid,$deviceremoteid) {
GLOBAL $dbh;
$insertdevice = $dbh->prepare ("INSERT INTO `devices` (name,brand,remoteid,channel) VALUES (:name,:brand,:remoteid,:channel)");
$insertdevice->bindParam(':name', $devicename);
$insertdevice->bindParam(':brand', $devicebrand);
$insertdevice->bindParam(':remoteid', $deviceremoteid);
$insertdevice->bindParam(':channel', $devicechannel);
$insertdevice->execute();
echo "<br><b>Device Added to Database</b><br />";
}

function addmac ($name,$mac) {
GLOBAL $dbh;
$insertmac= $dbh->prepare("INSERT INTO `wol` (`computer`, `mac`) VALUES (:computer, :mac)");
$insertmac->bindParam(':computer', $name);
$insertmac->bindParam(':mac', $mac);
$insertmac->execute();
echo "<br><b>WOL Added to Database</b><br />";
}

function adduser ($name,$number) {
GLOBAL $dbh;
$insertuser= $dbh->prepare("INSERT INTO `users` (`name`, `number`) VALUES (:name, :number)");
$insertuser->bindParam(':name', $name);
$insertuser->bindParam(':number', $number);
$insertuser->execute();
echo "<br><b>User Added to Database</b><br />";
}
?>