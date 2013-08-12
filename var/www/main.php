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
      $.get('index.php?page='+ this.id, function(data, status) {
           
     });
  });
});
</script>
<?php
$uptime = shell_exec("cut -d. -f1 /proc/uptime");
				$days = floor($uptime/60/60/24);
				$hours = $uptime/60/60%24;
				$mins = $uptime/60%60;
   ?>
 
   </head> 
   <body>
      <div data-role="page" id="home" data-theme="a" data-title="RPi Control">
         <div data-role="header">
            <h1>RPi Control</h1>
			
	
<?php
// Remove this section if no webcam is going to be used.
// Check if webcam is connected
// Edit the video0 if your cam is on a different addresses
$filename = '/dev/video0';

if (file_exists($filename)) {
// include file to see if motion service has been started.
    include('webcam2.php');
} else {
// Webcam not connected Message
    echo ('<center> Webcam not Connected </center>');
}
?>
			
         </div>
		<h2>
            <center>Remote Switch Using The Raspberry Pi</center>
        </h2>
        <div style="">
		<center>
            <img style="width: 200px; height: 150px" src="Raspberry_Pi_Logo-200x150.png">
        <center>
		</div>
         <div data-role="content">
			<center>
			<a href="#confirmation"><button data-inline="true" id="ch1on">Lamp On</button></a>
            <a href="#confirmation"><button data-inline="true" id="ch1off">Lamp Off</button></a>
			<br />
			<a href="#confirmation"><button data-inline="true" id="ch2on">TV on</button></a>
			<a href="#confirmation"><button data-inline="true" id="ch2off">TV off</button></a>
			<br />
			<a href="#confirmation"><button data-inline="true" id="ch3on">Kettle on</button></a>
			<a href="#confirmation"><button data-inline="true" id="ch3off">Kettle off</button></a>
			<br />
			<a href="#confirmation"><button data-inline="true" id="allon">All on</button></a>
			<a href="#confirmation"><button data-inline="true" id="alloff">All Off</button></a>
			<br />
			<a href="#two" data-role="button" data-mini="true"   data-inline="true">Pi Stats</a>
			<a href="#siri" data-role="button" data-mini="true"   data-inline="true">Siri</a></p>
			
			<center>
         </div>
         <div data-role="footer" data-position="fixed">   
            <h4><?php
			// Up Time Stats
			echo "This server is up $days days $hours hours $mins minutes.";
			?>
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
		<center><?php
include ('stats.php');	?>
<br />
			<button data-inline="true" data-mini="true"   id="reboot">reboot</button>
			<br />	
			<a href="#confirmation"><button data-inline="true" data-mini="true"   id="wol">Wake Up PC</button>
		<p><a href="#home" data-direction="reverse" data-role="button" data-theme="b">Back</a></p></center>
		
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4><?php
				// Up Time Stats
				echo "This server is up $days days $hours hours $mins minutes.";
			?>
			</h4> 
	</div><!-- /footer -->
</div><!-- /page two -->

<!-- Start of second page: #siri -->
<div data-role="page" id="siri" data-theme="a">

	<div data-role="header">
		<h1>Siri</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">	
		<center>
		
		<?php
		include ('siristatus.php'); 
		?>
		
		<p><a href="#home" data-direction="reverse" data-mini="true"   data-role="button" data-theme="b">Back</a></p>	
		
	</center></div><!-- /content -->
	
	<div data-role="footer">
		<h4><?php
				$uptime = shell_exec("cut -d. -f1 /proc/uptime");
				$days = floor($uptime/60/60/24);
				$hours = $uptime/60/60%24;
				$mins = $uptime/60%60;
				echo "This server is up $days days $hours hours $mins minutes.";
			?>
			</h4> 
	</div><!-- /footer -->
</div><!-- /page siri -->

   </body>
</html>