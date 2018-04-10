<?php
session_start();
$site = intval($_GET['q']);
$trench = $_GET['q1'];

$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
$db="is5108group-4__digdata";
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
			if (isset($_SESSION['currentContext']) and $_SESSION['currentContext'] == $row["ContextID"]) {
					echo '<option selected="selected" value="'.$row["ContextID"].'">'.$row["ContextNum"].'</option>';
					$_SESSION['currentContext'] = "";
			} else {
					echo '<option value="'.$row["ContextID"].'">'.$row["ContextNum"].'</option>';
			}
		}
	}
	else{
		echo "<option>No context available</option>";
	}

?>
