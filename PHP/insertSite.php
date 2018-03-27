
<?php
session_start();
$siteName=$_GET["name"];
$description=$_GET["description"];

$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
$db="is5108group-4__digdata";
$tb = "Site";

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
		mysqli_query($connect,"INSERT INTO `Site` (`SiteCode`, `SiteName`, `Description`) VALUES (NULL, '".$siteName."', '".$description."');");
			
		$_SESSION["addResult"] =  "A new site was added successfully";
		//echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
		//echo $found;
	}
	
?>