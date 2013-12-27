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
	 <script type="text/javascript">
$(function(){
  $("button").on("click", function(){
    var myId = $(this).attr("id");
	$.post( "index.php?="myId, {id:myId} );  
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
			<br />
         </div>
         <div data-role="footer" data-position="fixed">   
            <h4>
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
		<center>
<br />
			<button data-inline="true" data-mini="true"   id="reboot">reboot</button>
			<br />	
			<a href="#confirmation"><button data-inline="true" data-mini="true"   id="wol">Wake Up PC</button>
		<p><a href="#home" data-direction="reverse" data-role="button" data-theme="b">Back</a></p></center>
		
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>
			</h4> 
	</div><!-- /footer -->
</div><!-- /page two -->

<!-- /content -->
	
	<div data-role="footer">
		<h4>
			</h4> 
	</div><!-- /footer -->
</div>

   </body>
</html>