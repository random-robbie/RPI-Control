<?php
// Is Motion Started?
if(fsockopen("127.0.0.1",8081))
{
// Motion is started and running display the stream in Iframe
echo ('<center><img src="http://'.$_SERVER['SERVER_NAME'].':8081" width="320" height="240">');
// Remove this line if you do not have a 2nd camera
include ('webcam3.php');
echo ('<br /><button data-inline="true" id="motionstop">Stop Cam</button></center>');

}
else
{
// Webcam detected but motion service is not running
echo ('<center> Webcam not running
<br />
 </center>');
 include ('webcam3.php');
}
?>