<!DOCTYPE html>
<html>
<head>
<title>Installation Script</title>
</head>
<body>
<?php
$configfile = dirname( __FILE__ ) . '/../config.php';

if (file_exists($configfile)) {
    echo "RPI-Control is already installed.";
	exit();
} 
header('Location: install.php');
   exit;
?>
  <p>This is our site.</p>
</body>
</html>