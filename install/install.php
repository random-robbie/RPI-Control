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
$current = str_replace('install', '', $current2);
$configfile = "".$current."config.php";
$functionsfile = "".$current."functions.php";

function header2()
{
echo '
<html> 
   <head> 
      <title>Install</title> 
      <meta name="viewport" content="width=device-width, initial-scale=1"> 
	  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
	  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	  <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	  </head> 
	<body>
		<h2><center>Welcome to the RPI-Control Installer</h2>
<br>
<center>';
}

function footer2()
{
	echo '
		</center>
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
  case '8':
  header2();
  step_8();
  footer2();
  break;
  default:
  header2();
  step_1();
  footer2();
}
?>
<body>
<?php
function step_1(){ 
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agree'])){
  header('Location: install.php?step=2');
  exit;
 }
 if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['agree'])){
  echo "You must agree to the license.";
 }
?>
 <p>Our LICENSE will go here.</p>
 <form action="install.php?step=1" method="post">
 <p>
  I agree to the license
  <input type="checkbox" name="agree" />
 </p>
  <input type="submit" value="Continue" />
 </form>
 <?php 
}
function step_2(){
GLOBAL $configfile;
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] ==''){
   header('Location: install.php?step=3');
   exit;
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] != '')
   echo $_POST['pre_error'];
      
  if (phpversion() < '5.0') {
   $pre_error = 'You need to use PHP5 or above for our site!<br />';
  }
  if (!extension_loaded('mysql')) {
   $pre_error .= 'MySQL extension needs to be loaded for our site to work!<br />';
  }
  if (!extension_loaded('PDO')) {
   $pre_error .= 'PDO extension needs to be loaded for our site to work!<br />';
  }
  if (!is_writable($configfile)) {
   $pre_error .= 'config.php needs to be writeable for RPI-Control to be installed!';
  }
  ?>
  <table width="100%">
  <tr>
   <td>PHP Version:</td>
   <td><?php echo phpversion(); ?></td>
   <td>5.0+</td>
   <td><?php echo (phpversion() >= '5.0') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>MySQL:</td>
   <td><?php echo extension_loaded('mysql') ? 'On' : 'Off'; ?></td>
   <td>On</td>
   <td><?php echo extension_loaded('mysql') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>Mysql PDO:</td>
   <td><?php echo extension_loaded('PDO') ? 'On' : 'Off'; ?></td>
   <td>On</td>
   <td><?php echo extension_loaded('PDO') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>config.php</td>
   <td><?php echo is_writable($configfile) ? 'Writable' : 'Unwritable'; ?></td>
   <td>Writable</td>
   <td><?php echo is_writable($configfile) ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  </table>
  <form action="install.php?step=2" method="post">
   <input type="hidden" name="pre_error" id="pre_error" value="" />
   <input type="submit" name="continue" value="Continue" />
  </form>
<?php
}
function step_3(){
  if (isset($_POST['submit']) && $_POST['submit']=="Install!") {
   $database_host=isset($_POST['database_host'])?$_POST['database_host']:"";
   $database_name=isset($_POST['database_name'])?$_POST['database_name']:"";
   $database_username=isset($_POST['database_username'])?$_POST['database_username']:"";
   $database_password=isset($_POST['database_password'])?$_POST['database_password']:"";
  
  if (empty($database_host) || empty($database_username) || empty($database_name)) {
   echo "All fields are required! Please re-enter.<br />";
  } else {
   $connection = mysql_connect($database_host, $database_username, $database_password);
   if (!$connection) {
    die('Could not connect: ' . mysql_error());
}

$sql = 'CREATE DATABASE '.$database_name.'';
if (mysql_query($sql, $connection)) {
    echo "Database ".$database_name." created successfully\n";
} else {
    echo 'Error creating database: ' . mysql_error() . "\n";
}
$filename = "database.sql";
// Select database
mysql_select_db($database_name) or die('Error selecting MySQL database: ' . mysql_error());

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
    continue;

// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
    // Reset temp variable to empty
    $templine = '';
}
}
 echo "<br>Tables imported successfully<br><a href='install.php?step=4'>Next Step</a> If no Errors";
   
   GLOBAL $configfile;
   $handle = fopen($configfile, 'w') or die('Cannot open file:  '.$configfile);
   $data = '<?php
######################################################
#        RPI Control By Robert Wiggins				 #
#													 #
# http://www.github.com/txt3rob/RPI-Control/		 #
#													 #
#        Donate to txt3rob@gmail.com 				 #
#													 #
######################################################+
   
   
// Mysql Config
$dbuser = "'.$database_username.'";
$dbpass = "'.$database_password.'";
$dbname = "'.$database_name.'";
$dbhost = "'.$database_host.'";

try {
// database connection
$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>';
  fwrite($handle, $data);
  }
  header ('Location install.php?step=4');
  }
?><script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("install.php?step=3",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
  <form method="post" action="install.php?step=3">
  <p>
   <label for="database_host">Database Host</label>
   <input type="text" name="database_host" value='localhost' size="30">
 </p>
 <p>
	<label for="database_name">Database Name</label>
   <input type="text" name="database_name" size="30" value="">
 </p>
 <p>
	<label for="database_username">Database Username</label>
   <input type="text" name="database_username" size="30" value="">
 </p>
 <p>
	<label for="database_password">Database Password</label>
   <input type="text" name="database_password" size="30" value="">
   </p>
  <br/>
 <p>
   <input type="submit" name="submit" value="Install!">
  </p>
  </form>
  <div id="results"></div>
<?php
}
function step_4(){

?>
<body>
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("install.php?step=4",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<form method="post" action="install.php?step=4">
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
<input type="submit" name="submit" value="Add Device"></form> <a href="install.php?step=5"><button>Next</button></a>
<div id="results"></div>
<?php
if (isset($_POST['submit']) && $_POST['submit']=="Add Device") {
   $devicename=isset($_POST['name'])?$_POST['name']:"";
   $devicebrand=isset($_POST['brand'])?$_POST['brand']:"";
   $devicechannel=isset($_POST['channel'])?$_POST['channel']:"";
   $deviceremoteid=isset($_POST['remoteid'])?$_POST['remoteid']:"";
  
  if (empty($devicename) || empty($devicechannel) || empty($deviceremoteid) || empty($devicebrand)) {
   echo "All fields are required! Please re-enter.<br />";
} else {
include ''.$configfile.'';
include ''.$functionsfile.'';
addevice ($devicename,$devicebrand,$deviceremoteid,$devicechannel);
}
}
}
function step_5(){
?>
<h1> Add a SMS Provider</h1>
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("install.php?step=5",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<?php
$current2 = getcwd();
$current = str_replace('install', '', $current2);
$dir = "".$current."sms/";
$results = glob($dir."*.php");
$diremove = str_replace($dir, '', $results);
GLOBAL $configfile;
GLOBAL $functionsfile;
GLOBAL $dbh;

?>
<form method="post" action="install.php?step=5">
<select name="smsprovider">
<?php 
foreach ($results as $provider)
{
echo '<option value="'.$provider.'">'.$provider.'</option>';
}

?>
</select>
<input type="submit" name="submit" value="submit"></form> <a href="install.php?step=6"></form><button>Next</button></a>
<div id="results"></div>
<?php

if (isset($_POST['submit']) && $_POST['submit']=="submit") {
$script = $_POST['smsprovider'];
GLOBAL $configfile;
GLOBAL $dbh;
GLOBAL $functionsfile;

include ''.$configfile.'';
$use = "1";
$insertsmsprov = $dbh->prepare("INSERT INTO `smsprovider` (script,`use`) VALUES (:script,:use)");
$insertsmsprov->bindParam(':script', $script);
$insertsmsprov->bindParam(':use', $use);
$insertsmsprov->execute();
echo "<br><b>Provider Added to Database</b><br />";
}
}
function step_6(){

?>
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("install.php?step=6",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<h1>Allow Control </h1>
<form method="post" action="install.php?step=6" id="post">
Name: <input type="text" name="name"><br>
Mobile Number: <input type="text" name="number"><br>
<input type="submit" name="submit" value="Add User"></form><a href="install.php?step=7"><button>Next</button></a>
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
function step_7(){
GLOBAL $configfile;
include (''.$configfile.'');
GLOBAL $dbh;
GLOBAL $functionsfile;
?>
<script>
$(document).ready(function(){
    $("submit").click(function(){
        $.post("install.php?step=7",
            $('#post').serialize(),
            function(data,status){
                $('#results').append(data);
            }
        );
    });
});
</script>
<h1>Wake On LAN </h1>
<form method="post" action="install.php?step=7" id="post">
Name: <input type="text" name="name"><br>
MAC: <a href="http://www.wikihow.com/Find-the-MAC-Address-of-Your-Computer">?</a><input type="text" name="mac" value ="00:00:00:00:00:00"><br>
<input type="submit" name="submit" value="add wol"><a href='install.php?step=8'><button>Finish</button></a>
<br><div id="results"></div>
<?php
if (isset($_POST['submit']) && $_POST['submit']=="add wol") {
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
?>
<?php
function step_8(){
echo ('
<div> You have now finished the installer please remove the /install/ folder <br />
      
</div>');

}
}
?>