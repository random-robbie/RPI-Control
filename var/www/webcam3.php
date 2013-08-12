<?php
// Is Motion Started?
if(fsockopen("192.168.0.9",8083))
{
// Motion is started and running display the stream in Iframe
echo('<img src="http://'.$_SERVER['SERVER_NAME'].':8083/videofeed" width="320" height="240">');

}
else
{
// Webcam detected but motion service is not running
echo ('<center> backgarden not running
<br />
 </center>');
}
?>