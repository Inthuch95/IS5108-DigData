<?php
session_start();
$userID=$_POST["user"];
$site=$_POST["site"];
$trench=$_POST["trench"];
$contextID=$_POST["contextID"];
$date=$_POST["date"];
$type=$_POST["type"];
$description=$_POST["description"];
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
  $sql ="INSERT INTO $tb (`FindID`,`UserID`, `ContextID`, `Description`,`Type`,`Date`)
  VALUES (NULL, '".$userID."', '".$contextID."', '".$description."', '".$type."', '".$date."');";
  mysqli_query($connect,$sql);
  
  $sql = "SELECT MAX(FindID) AS maxFindID FROM Finds";
  //VALUES (NULL, '".$siteName."', '".$description."');");

  $_SESSION["addResult"] =  "A new record was added successfully";
  //echo $query;
 
  // INSERT INTO `is5108group-4__digdata`.Finds (UserID,ContextID,Description,`Type`,`Date`)
  // VALUES (1,4,'Jack the ripper knife','Metal','2018-03-08') ;

  //echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
  //echo $found;
}

uploadImg("imgs");

function uploadImg($id){
	global $photoSetID,$connect;

	insertPhotoSet();
	echo "<br>PhotoSetID:".$photoSetID."</br>";
	$target_dir = "../record images/";
	foreach($_FILES[$id]["name"] as $f => $name){
		$target_file = $target_dir . basename($_FILES[$id]["name"][$f]);
		$path = "record images/".basename($_FILES[$id]["name"][$f]);

		$uploadOK = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$check = getimagesize($_FILES[$id]["tmp_name"][$f]);
		 if($check !== false) {
			 /*
			 echo $target_file;
			 echo "<br>".$path."<br>";
			 echo "File is an image - " . $check["mime"] . ".";
			 */

			 $uploadOk = 1;
		 } else {
			 echo "File is not an image.";
			 $uploadOk = 0;
		 }
		 
		$sql = "INSERT INTO `Photos` (`FrameID`, `PhotoSetID`, `Directory Path`) VALUES (NULL, '$photoSetID', '$path')";
		mysqli_query($connect,$sql);
		

		// Check if file already exists
		if (file_exists($target_file)) {
		   echo "Sorry, file already exists.";
		   $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}

		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES[$id]["tmp_name"][$f], $target_file)) {
				echo "The file ". basename( $_FILES[$id]["name"][$f]). " has been uploaded.";
				//
				//INSERT INTO `Photos` (`FrameID`, `PhotoSetID`, `Directory Path`) VALUES (NULL, '1', '/context images/Batman.jpeg');
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}


	}
	 header("Location:../add_record.php");
}

function insertPhotoSet(){
	global $site, $trench,$contextID, $connect, $direction, $date, $photoSetID;
	$sql ="INSERT INTO `PhotoSets` (`PhotoSetID`, `SiteCode`, `Trench`, `Description`, `Direction`, `Date`)
	VALUES (NULL, '$site', '$trench', '', '', '$date')";
	echo "<br>".$sql."<br>";

	if ($connect->query($sql) === TRUE) {
		
		echo "New photoset created successfully";

	} else {
		echo "Error: " . $sql . "<br>" . $connect->error;
	}



	// Get the latest photosetID
	$sql = "SELECT MAX(PhotoSetID) AS maxPhotoSetID FROM PhotoSets";

	$find = mysqli_query($connect,$sql);

	$row=mysqli_fetch_array($find,MYSQLI_ASSOC);
	$photoSetID = intval($row["maxPhotoSetID"]);
	
	$sql = "SELECT MAX(FindID) AS maxFindID FROM Finds";
	
	$find = mysqli_query($connect,$sql);
	$row=mysqli_fetch_array($find,MYSQLI_ASSOC);
	$findID = intval($row["maxFindID"]);
	
	//NSERT INTO `PhotoSet-Find Links` (`LinkID`, `PhotoSetID`, `FindID`) VALUES (NULL, '', '')
	//echo "<br>PhotoSetID:".$photoSetID."</br>";
	$sql = "INSERT INTO `PhotoSet-Find Links` (`LinkID`, `PhotoSetID`, `FindID`) VALUES (NULL, '$photoSetID', '$findID')";
	mysqli_query($connect,$sql);
	echo "<br>".$sql."<br>";


}


?>
