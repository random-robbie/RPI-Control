<?php
$username = "";
$password = "";
$dbname = "";
$tablename = "texts";
$hostname = ""; 

// Configuration variables. Consult http://www.txtlocal.co.uk/developers/ for more info.
$info = "1"; // set to 1 to show debug info, 0 to hide it
$test = "0"; // set to 1 to only send test messages (doesnt use credits), set to 0 to send sms messages
  
$keyword = "";//The keyword you wish to send a response for, Case Sensitive.


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
$sql1 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '99DQF light on'";
$query = mysql_query( $sql1, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{
    passthru('sudo ch1on');
	echo "<br>Turning light on ";
}
else
{
    echo "<br>light on not found";
}
$sql2 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '99DQF light off'";
$query = mysql_query( $sql2, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{
	passthru('sudo ch1off');
    echo "<br>Turning light off ";
}
else
{
    echo "<br>light off not found";
}

$sql3 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '99DQF tv on'";
$query = mysql_query( $sql3, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{
	passthru('sudo ch2on');
    echo "<br>Turning Tv on ";
}
else
{
    echo "<br>TV on not found";
}

$sql4 = "SELECT * FROM ".$tablename." WHERE forward = '0' AND `content` = '99DQF tv off'";
$query = mysql_query( $sql4, $dbhandle );
if ( mysql_num_rows( $query ) > 0 )
{	
	passthru('sudo ch2off');
    echo "<br>Turning Tv off ";
}
else
{
    echo "<br>TV off not found";
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
   // Remote blank rows if page is accessed and no data is passed.
   mysql_query("DELETE FROM `texts` WHERE `sender` = 0");
   ?>