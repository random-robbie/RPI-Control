<?php
$ip = $_SERVER['SERVER_ADDR'];
// Change Ip for your Siri proxy
if(fsockopen($ip,443))
{
$externalContent = file_get_contents('http://www.icanhazip.com/');
echo ('<center>
<img src="siri-small.jpg">
<br />
Siri Is Running
<br />
Please set your DNS to '.$ip.' or '.$externalContent.' to use this siriproxy
<br />
You will also need to install the following certificate please
<Br>
<a href="ca.pem">Click here to grab it</a>
<br />
<a href="#confirmation"><button data-inline="true" id="sirikill">Stop Siri</button></a>
<a href="#confirmation"><button data-inline="true" id="gencert">Generate Certificate</button></a>
<br />
</center>');

}
else
{
echo ('
<center>
<img src="offline.jpg">
<br />
Siri is not running</center>
<br />
<button data-inline="true" id="siristart">Siri Start</button>

<br /></center>');
}
?>
