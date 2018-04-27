<?php
session_start();
$site = $_POST["site"];
$trench = $_POST["trench"];

//$contextNum = $_POST["contextNum"];
$contextID = $_POST["contextID"];
$description = $_POST["description"];

$direction = $_POST["direction"];
$addingDate = $_POST["date"];
$photoSetID =0;

include 'databaseConfig.php';


$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}

uploadImg("imgs");

function uploadImg($id){
	global $photoSetID,$connect,$contextID;

	print_r($_FILES[$id]);
	insertPhotoSet();
	echo "<br>PhotoSetID:".$photoSetID."</br>";
	$target_dir = "../context images/";
	foreach($_FILES[$id]["name"] as $f => $name){
		$target_file = $target_dir .$contextID."_". basename($_FILES[$id]["name"][$f]);
		$path = "context images/".$contextID."_".basename($_FILES[$id]["name"][$f]);

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
		
		echo "<br>".$sql."<br>";

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
	$connect->close();
	header("Location:../add_photo.php");
	
}


function insertPhotoSet(){
	global $site, $trench,$contextID, $connect, $description, $direction, $addingDate, $photoSetID;
	$sql ="INSERT INTO `PhotoSets` (`PhotoSetID`, `SiteCode`, `Trench`, `Description`, `Direction`, `Date`)
	VALUES (NULL, '$site', '$trench', ?, '$direction', '$addingDate')";

	$stmt = $connect->prepare($sql);  //prepares the query for action
	$stmt->bind_param("s", $description);  
	echo "<br>".$sql."<br>";

	if ($stmt->execute() === TRUE) {
		$_SESSION["addResult"] = "New photoset was added successfully";
		echo "New photoset created successfully";

	} else {
		echo "Error: " . $sql . "<br>" . $connect->error;
	}



	// Get the latest photosetID
	$sql = "SELECT MAX(PhotoSetID) AS maxPhotoSetID FROM PhotoSets";

	$find = mysqli_query($connect,$sql);

	$row=mysqli_fetch_array($find,MYSQLI_ASSOC);
	$photoSetID = intval($row["maxPhotoSetID"]);
	

	
	//echo "<br>PhotoSetID:".$photoSetID."</br>";
	$sql = "INSERT INTO `PhotoSet-Context Links` (`LinkID`, `PhotoSetID`, `ContextID`) VALUES (NULL, '$photoSetID', '$contextID')";
	mysqli_query($connect,$sql);
	echo "<br>".$sql."<br>";


}




?>
