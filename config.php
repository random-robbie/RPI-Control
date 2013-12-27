<?php
######################################################
#        RPI Control By Robert Wiggins				 #
#													 #
# http://www.github.com/txt3rob/RPI-Control/		 #
#													 #
#        Donate to txt3rob@gmail.com 				 #
#													 #
######################################################+
   
   
// Mysql Config
$dbuser = "root";
$dbpass = "raspberry";
$dbname = "rpicontrol";
$dbhost = "localhost";

try {
// database connection
$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>