<?php
 switch(@$_GET['page']){
    case "shutdown":
      passthru('sudo shutdown -h now');
         break;
      case "reboot":
       passthru('sudo reboot');
         break;
	  case "ch1on":
       passthru('sudo ch1on');
		 break;
	  case "ch1off":
         passthru('sudo ch1off');
		 break;
	  case "ch2on":
         passthru("sudo ch2on");
		 break;
	  case "ch2off":
         passthru('sudo ch2off');
		 break;
	  case "ch3on":
         passthru('sudo ch3on');
		 break;
	  case "ch3off":
         passthru('sudo ch3off');
		 break;
	  case "ch4on":
         passthru('sudo ch4on');
		 break;
	  case "ch4off":
         passthru('sudo ch4off');
		 break;
	  case "alloff":
         passthru('sudo alloff');
		 break;
	  case "allon":
         passthru('sudo allon');
		 break;
		 case "motionstop":
         passthru('sudo service motion stop');
		 echo ('Stopping Motion Service');
		 break;
		 case "motionstart":
         passthru('sudo service motion start');
		 echo ('Starting Motion Service');
		 break;
		 case "siristart":
         passthru('sudo service siriproxylog start');
		 echo ('Siri Starting');
		 break;
		case "sirikill":
		 passthru('sudo service siriproxylog stop');
         passthru('sudo pkill ruby');
		 echo ('killing Siri');
		 break;
		 case "wol":
         $wol = passthru('wakeonlan 54:04:A6:C0:54:DD');
		 echo $wol;
		 case "gencert":
         passthru('sudo gencert');
		 break;
		 break;
    default : 
	include ('main.php');
 }
?>
