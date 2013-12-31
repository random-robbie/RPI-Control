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
$current = str_replace('admin', '', $current2);
$configfile = "".$current."config.php";
$functionsfile = "".$current."functions.php";

function header2()
{
echo '
<html> 
   <head> 
      <title>admin</title> 
      <meta name="viewport" content="width=device-width, initial-scale=1"> 
	  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
	  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	  <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	  </head> 
	<body>
		<h2><center>Welcome to the RPI-Control Admin Panel</h2>
		<div align="center">
		<img src=".././images/Raspberry_Pi_Logo-200x150.png"></div>
		
<br>
<center>';
}

function footer2()
{
	echo '</body>
		</center>
		</div>
		</div>
	</body>
</html>';
}

$step = (isset($_GET['step']) && $_GET['step'] != '') ? $_GET['step'] : '';
switch($step){
  case '1':
  header2();
  step_1();
  footer2();
  break;
  case '2':
  header2();
  step_2();
  footer2();
  break;
  case '3':
  header2();
  step_3();
  footer2();
  break;
  case '4':
  header2();
  step_4();
  footer2();
  break;
  case '5':
  header2();
  step_5();
  footer2();
  break;
  case '6':
  header2();
  step_6();
  footer2();
  break;
  case '7':
  header2();
  step_7();
  footer2();
  break;
  default:
  header2();
  step_1();
  footer2();
}
?>

<?php
function step_1(){ 
$url2 = $_SERVER['REQUEST_URI'];
$url = str_replace('/admin', '', $url2)
?>
<div align="center">
<a href="index.php?step=2" data-role="button" data-inline="true">Add Devices</a><a href="index.php?step=3" data-role="button" data-inline="true">Remove Devices</a><br />
<a href="index.php?step=4" data-role="button" data-inline="true">Add Users</a><a href="index.php?step=5" data-role="button" data-inline="true">Remove Users</a><br />
<a href="index.php?step=6" data-role="button" data-inline="true">Add Wol</a><a href="index.php?step=7" data-role="button" data-inline="true">Remove WOL</a><br />
<br />
<a href="<?php echo $url;?>" data-role="button" data-inline="true">Main Page</a>
</div>
<?php
}

?>
<?php
function step_2(){ 
GLOBAL $configfile;
GLOBAL $functionsfile;
?>

<script>
$(document).ready(function(){
    $("Add Device").click(function(){
        $.post("index.php?step=2",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<form method="post" action="index.php?step=2">
Device Name: <input type="text" name="name"><br>
Brand:
<select name="brand">
<option value="5">Status</option>
<option value="0">Nexa</option>
</select>
<br />
Remote ID: <input type="text" name="remoteid" Value ="196608"><br>
Channel:
<select name="channel">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
</select>
<input type="submit" name="submit" data-inline="true" value="Add Device"><a href="index.php?step=1" data-role="button" data-inline="true">Back</a>
<div id="results"></div></form>
<?php
if (isset($_POST['submit']) && $_POST['submit']=="Add Device") {
   $devicename=isset($_POST['name'])?$_POST['name']:"";
   $devicebrand=isset($_POST['brand'])?$_POST['brand']:"";
   $devicechannel=isset($_POST['channel'])?$_POST['channel']:"";
   $deviceremoteid=isset($_POST['remoteid'])?$_POST['remoteid']:"";
  
  if (empty($devicename) || empty($devicechannel) || empty($deviceremoteid) || empty($devicebrand)) {
   echo "All fields are required! Please re-enter.<br />";
} else {
include ($configfile);
include ($functionsfile);
add_device ($devicename,$devicebrand,$deviceremoteid,$devicechannel);
}
}
}

function step_3(){ 
GLOBAL $configfile;
GLOBAL $functionsfile;
include ($configfile);
include ($functionsfile);
?>

<div align="center"><h2>Remove Device</h2>
<br />
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("index.php?step=3",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<form action="index.php?step=3" method="post">
<select name="device" data-inline="true">
<?php 
			foreach ($devices as $device)
			{
			echo'<option value="'.$device['name'].'">'.$device['name'].'</option>'; 
			}
			?>
			</select>
			<input type="submit" value="Submit" data-inline="true"></form><a href="index.php?step=1" data-role="button" data-inline="true">back</a>
			<div id="results">
<?php
if (isset($_POST['device'])) {
   $device=isset($_POST['device'])?$_POST['device']:"";
removedevice ($device);
sleep(02);
refreshpage ($_SERVER['REQUEST_URI']);



}
}
function step_4(){ 
?>
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("index.php?step=4",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<h1>Allow Control </h1>
<form method="post" action="index.php?step=4" id="post">
Name: <input type="text" name="name"><br>
Mobile Number: <input type="text" name="number"><br>
<input type="submit" name="submit" data-inline="true" value="Add User"> <a href="index.php?step=1" data-role="button" data-inline="true">Back</a></form>
<br><div id="results"></div>

<?php
GLOBAL $configfile;
GLOBAL $dbh;
GLOBAL $functionsfile;
if (isset($_POST['submit']) && $_POST['submit']=="Add User") {
   $name=isset($_POST['name'])?$_POST['name']:"";
   $number=isset($_POST['number'])?$_POST['number']:"";

  
  if (empty($name) || empty($number)) {
   echo "All fields are required! Please re-enter.<br />";
} else {
GLOBAL $configfile;
include (''.$configfile.'');
include (''.$functionsfile.'');
adduser ($name,$number);
}
}
}

function step_5(){ 
GLOBAL $configfile;
GLOBAL $functionsfile;
include ($configfile);
include ($functionsfile);
?>

<div align="center"><h2>Remove User</h2>
<br />
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("index.php?step=5",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<form action="index.php?step=5" method="post">
<select name="users" data-inline="true">
<?php 
			foreach ($users as $user)
			{
			echo'<option value="'.$user['name'].'">'.$user['name'].' - '.$user['number'].'</option>'; 
			}
			?>
			</select>
			<input type="submit" value="Submit" data-inline="true"></form><a href="index.php?step=1" data-role="button" data-inline="true">back</a>
			<div id="results">
<?php
if (isset($_POST['users'])) {
   $use=isset($_POST['users'])?$_POST['users']:"";
removeuser ($use);
sleep(02);
refreshpage ($_SERVER['REQUEST_URI']);


}
}
function step_6(){ 
GLOBAL $configfile;
include ($configfile);
GLOBAL $dbh;
GLOBAL $functionsfile;
?>
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("index.php?step=6",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<h1>Wake On LAN </h1>
<form method="post" action="index.php?step=6" id="post">
Name: <input type="text" name="name"><br>
MAC: <a href="http://www.wikihow.com/Find-the-MAC-Address-of-Your-Computer">?</a><input type="text" name="mac" value="00:00:00:00:00:00"><br>
<input type="submit" name="submit" data-inline="true" value="Add"><a href='index.php?step=1' data-role="button" data-inline="true">Back</a>
<br><div id="results"></div>
<?php
if (isset($_POST['submit']) && $_POST['submit']=="Add") {
   $name=isset($_POST['name'])?$_POST['name']:"";
   $mac=isset($_POST['mac'])?$_POST['mac']:"";

  
  if (empty($name) || empty($mac)) {
   echo "All fields are required! Please re-enter.<br />";
} else {
GLOBAL $configfile;
include (''.$configfile.'');
GLOBAL $functionsfile;
include (''.$functionsfile.'');
addmac ($name,$mac);
}
}
}
function step_7(){ 
GLOBAL $configfile;
GLOBAL $functionsfile;
include ($configfile);
include ($functionsfile);
?>

<div align="center"><h2>Remove Wake on Lan Device</h2>
<br />
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("index.php?step=7",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<form action="index.php?step=7" method="post">
<select name="woldev" data-inline="true">
<?php 
			foreach ($wollist as $woldev)
			{
			echo'<option value="'.$woldev['computer'].'">'.$woldev['computer'].' - '.$woldev['mac'].'</option>'; 
			}
			?>
			</select>
			<input type="submit" value="Submit" data-inline="true"></form><a href="index.php?step=1" data-role="button" data-inline="true">back</a>
			<div id="results">
<?php
if (isset($_POST['woldev'])) {
   $woldev=isset($_POST['woldev'])?$_POST['woldev']:"";
removewol ($woldev);
refreshpage ($_SERVER['REQUEST_URI']);
}
}

?>