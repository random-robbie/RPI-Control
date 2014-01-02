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
include ('functions.php');
?>
<html> 
   <head> 
      <title>Home</title> 
      <meta name="viewport" content="width=device-width, initial-scale=1"> 
	  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
	  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	  <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<script>
 $(document).ready(function(){
 $('button').click(function() {
      $.get('index.php?id='+ this.id, function(data, status) {
 window.location.reload(false);          
     });
  });
});
</script>
 
   </head> 
   <body>
      <div data-role="page" id="home" data-theme="a" data-title="RPi Control">
         <div data-role="header">
            <h1>RPi Control</h1>
         </div>
		<h2>
            <center>Remote Switch Using The Raspberry Pi</center>
        </h2>
        <div style="">
		<center>
            <img style="width: 200px; height: 150px" src="./images/Raspberry_Pi_Logo-200x150.png">
        <center>
		</div>
         <div data-role="content">
			<center>
			<?php 
			foreach ($devices as $device)
			{
			echo'<a href="#confirmation"><button data-inline="true" id="'.$device['name'].'-on">'.$device['name'].' On</button></a><a href="#confirmation"><button data-inline="true" id="'.$device['name'].'-off">'.$device['name'].' Off</button></a>'; 
			if ($device['state'] == "1")
			{
			echo '<img src = "./images/on.png">';
			} else {
			echo '<img src = "./images/off.png">';
			}
			echo '<br />';
			}
			?>
			<a href="#confirmation"><button data-inline="true" id="all-on">All On</button></a><a href="#confirmation"><button data-inline="true" id="all-off">All Off</button></a><br />
			<br />
			
			<a href="#two"><button data-inline="true">Stats</button></a><a href="#wol"><button data-inline="true">Wake On Lan</button></a>
         </div>
         <div data-role="footer" data-position="fixed">   
            <h4>
			<?php
		uptime(); ?>
			</h4>      
         </div>
      </div> 
      <div data-role="dialog" id ="confirmation" data-theme="a" data-title="Confirmation">
         <div data-role="header" data-theme="a">
            <h1>Action performed</h1>
         </div>
         <div data-role="content" data-theme="c">
            <h1>The Action has been performed</h1>
            <a href="#" data-role="button" data-rel="back" data-theme="c">Okay</a>
         </div>
      </div>
      <!-- Start of second page: #two -->
<div data-role="page" id="two" data-theme="a">

	<div data-role="header">
		<h1>Stats</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">	
		<center><pre>
<b>Uptime:</b> 
<?php system("uptime"); ?>

<b>System Information:</b>
<?php system("uname -a"); ?>


<b>Memory Usage (MB):</b> 
<?php system("free -m"); ?>


<b>Disk Usage:</b> 
<?php system("df -h"); ?>


<b>CPU Information:</b> 
<?php system("cat /proc/cpuinfo | grep \"model name\\|processor\""); ?>
</pre>
<br />
<p><a href="#home" data-direction="reverse" data-role="button" data-theme="b">Back</a></p></center>
		
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4><?php
		uptime(); ?>
			</h4> 
	</div><!-- /footer -->
</div><!-- /page two -->

<!-- /content -->
	
	<!-- Start of second page: #wol -->
<div data-role="page" id="wol" data-theme="a">


	<div data-role="header">
		<h1>Wake On Lan</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">
		<h4><?php
		wollistings (); ?>
		<div id="results"></div>
		<a href="#home" data-direction="reverse" data-role="button" data-theme="b">Back</a></p></center>
			</h4> 
	</div><!-- /footer -->
<div data-role="footer">
		<h4><?php
		uptime(); ?>
			</h4> 
	</div><!-- /footer -->

   </body>
</html>