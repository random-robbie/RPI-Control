<?php

// Check if webcam is connected
// Edit the video0 if your cam is on a different addresses
$filename = '/dev/video0';

if (file_exists($filename)) {
    include('webcam2.php');
	
} else {
// Webcam not connected Message
    echo ('<center> Webcam not connected ');
	 echo ('</center>');
}
?>