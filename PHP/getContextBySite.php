<?php
session_start();
$site = intval($_GET['q']);
$trench = $_GET['q1'];

include 'databaseConfig.php';

$tb = "Context_Records";

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
			$find = mysqli_query($connect,"SELECT * FROM $tb where SiteCode=$site and Trench='".$trench."'");
			$found = mysqli_num_rows($find);
		//echo "SELECT * FROM $tb where SiteCode=$site and Trench='".$trench."'";
		//echo $found;
	}
	if($found){
		echo '<option value = "">Select context</option>';
		while ($row=mysqli_fetch_array($find,MYSQLI_ASSOC)) {
				echo '<option value="'.$row["ContextID"].'">'.$row["ContextNum"].'</option>';
		}
	}
	else{
		echo "<option>No context available</option>";
	}

?>
