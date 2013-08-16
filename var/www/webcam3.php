<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/www/config.php'); 

// Is Motion Started?
// Alter the IP address and port to the IP of your 2nd cam
if(fsockopen($webcam2,$webcam2port))
{
// Motion is started and running display the stream in Iframe
echo('<img src="http://'.$_SERVER['SERVER_NAME'].':'.$webcam2port.'/videofeed" width="320" height="240">');

}
else
{
// Webcam detected but motion service is not running
echo ('<center> backgarden not running<br /></center>');
}
?>