<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/www/config.php'); 


//##################### POST settings & MYSQL Connections #############
 
//POST, this is the code that receives new texts
$sender = $_REQUEST['sender'];
$content = $_REQUEST['content'];
$inNumber = $_REQUEST['inNumber'];
$email = $_REQUEST['email'];
$credits = $_REQUEST['credits'];
 
//establish a connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL". mysql_error());
 
//select a database to work with
$selected = mysql_select_db($dbname,$dbhandle)
  or die(mysql_error());
 
// inserts POST'd text messages from txtlocal api
  $insertsms = mysql_query("INSERT INTO ".$tablename." (sender,content,inNumber,email,credits) VALUES ('".$sender."', '".$content."', '".$inNumber."', '".$email."', '".$credits."')");

// Looking for the key phrases to action
$sql1 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '$keyword $item1 on'";
$query = mysql_query( $sql1, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{
    passthru('sudo ch1on');
	echo "<br>".$item1." on ";
}
else
{
    echo "<br>".$item1." on not found";
}
$sql2 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '$keyword $item1 off'";
$query = mysql_query( $sql2, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{
	passthru('sudo ch1off');
    echo "<br>".$item1." off ";
}
else
{
    echo "<br>".$item1." off not found";
}

$sql3 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '$keyword $item2 on'";
$query = mysql_query( $sql3, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{
	passthru('sudo ch2on');
    echo "<br>Turning ".$item2." on ";
}
else
{
    echo "<br>".$item2." on not found";
}

$sql4 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '$keyword $item2 off'";
$query = mysql_query( $sql4, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{	
	passthru('sudo ch2off');
    echo "<br>".$item2." Tv off ";
}
else
{
    echo "<br>".$item2." off not found";
	}
$sql5 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '$keyword $item3 on'";
$query = mysql_query( $sql5, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{	
	passthru('sudo ch3on');
    echo "<br>".$item3." on ";
}
else
{
    echo "<br>".$item3." on not found";
	}

$sql7 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '$keyword all off'";
$query = mysql_query( $sql7, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{	
	passthru('sudo alloff');
    echo "<br>all off ";
}
else
{
    echo "<br>alloff not found";
	}
$sql8 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '$keyword all on'";
$query = mysql_query( $sql8, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{	
	passthru('sudo allon');
    echo "<br>all on ";
}
else
{
    echo "<br>all on not found";
	}

  
  
  //##################### CHECK FOR KEYWORDS #############
 
 $fetchsms = mysql_query("SELECT * FROM ".$tablename." WHERE forward = '0'")
 or die(mysql_error()); 
 
   while($storedsms = mysql_fetch_array($fetchsms)){
 
        $smscontent = $storedsms['content']; //load content so we can check the string for a keyword 
 
      if (strpos($smscontent,$keyword) !== false) { //check for the keyword
              $id = $storedsms['id']; //set current id
              $selected = mysql_query("UPDATE ".$tablename."  SET forward = '1' WHERE id = '$id' ");//updates the record to show it needs to be forwarded
      }//end if
    }//end while
	

	################# CHECK FOR FLAG AND FORWARD MESSAGE ########
 
 //here we pull all the records in the table that are flagged as 'forward' but have not yet been sent.
  $checkforward = mysql_query("SELECT * FROM ".$tablename." WHERE forward = '1' AND messagesent = '0' ")
     or die(mysql_error()); 
 
   while($storedsms = mysql_fetch_array($checkforward)){ //we need to loop around each message to send a text
 
   $smscontent = $storedsms['content']; //load content so we can check the string for a keyword 
 $id = $storedsms['id']; //set current id into a variable
$selected = mysql_query("UPDATE ".$tablename." SET messagesent = '1' WHERE id = '$id' ");//updates 'messagesent' to show it has been sent out.
 
   }//end while
   // Remove blank rows if page is accessed and no data is passed.
   mysql_query("DELETE FROM `texts` WHERE `sender` = 0");
   ?>