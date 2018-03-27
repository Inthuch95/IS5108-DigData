<?php
session_start();
$findID=$_GET["id"];

$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
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
    $find = mysqli_query($connect,"SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM $tb INNER JOIN Context_Records cr
      ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode WHERE $tb.FindID = $findID");
    $row = mysqli_fetch_array($find, MYSQLI_ASSOC);
		//echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
		//echo $found;
	}
?>
<div class="row">
 <div class="col-sm-12">
         <table class="table table-hover table-bordered">
             <tbody>
             <tr>
                 <td width="100">
                     <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100"
                          class="center-block" alt="Cinque Terre">
                 </td>
                 <td>
                     <table class="table table-bordered">
                         <tbody>
                         <tr>
                             <td><strong>ID: </strong><?php printf ("%s", $row["FindID"])?></td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Location: </strong><?php printf ("%s", $row["SiteName"])?> <strong>Founder: </strong><?php printf ("%s", $row["UserID"])?> <strong>Date: </strong><?php printf ("%s", $row["Date"])?>
                             </td>
                         </tr>
                         <tr>
                             <td><strong>Description: </strong><?php printf ("%s", $row["FDESC"])?>
                             </td>
                         </tr>
                         <tr>
                             <td>Lorem ipsum donec id elit non mi porta gravida at eget metus.</td>
                         </tr>
                         </tbody>
                     </table>
                 </td>
             </tr>
             </tbody>
         </table>
     </div>
 </div>
