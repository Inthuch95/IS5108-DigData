<?php
session_start();
$userID=$_GET["user"];
$siteCode=$_GET["site"];
$trench=$_GET["trench"];
$contextID=$_GET["context"];
$date=$_GET["date"];
$type=$_GET["type"];
$description=$_GET["description"];
$host="is5108group-4.host.cs.st-andrews.ac.uk";
//$host="localhost";
$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$db="is5108group-4__digdata";
$tb = "Finds";

	$connect= mysqli_connect($host,$username,$password);
if (!$connect )
  {
    echo "Can't connect to SQLdatabase ";
    exit();
  }
else
{
  mysqli_select_db($connect,$db) or die("Can't select Database");
  //SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM Finds INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode ORDER BY `Date` DESC
  $query ="INSERT INTO $tb (`FindID`,`UserID`, `ContextID`, `Description`,`Type`,`Date`)
  VALUES (NULL, '".$userID."', '".$contextID."', '".$description."', '".$type."', '".$date."');";
  mysqli_query($connect,$query);
  //VALUES (NULL, '".$siteName."', '".$description."');");

  $_SESSION["addResult"] =  "A new record was added successfully";
  //echo $query;
  header("Location:../add_record.php");
  // INSERT INTO `is5108group-4__digdata`.Finds (UserID,ContextID,Description,`Type`,`Date`)
  // VALUES (1,4,'Jack the ripper knife','Metal','2018-03-08') ;

  //echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
  //echo $found;
}
?>
