<?php
session_start();
$site = $_POST["site"];
if ($_POST["trench"] == "New trench"){
  $trench = $_POST["newTrench"];
} else {
  $trench = $_POST["trench"];
}
$contextNum = $_POST["contextNum"];
$contextID = $_POST["contextID"];
$description = $_POST["description"];
$interpretation = $_POST["interpretation"];
echo $interpretation;
// East
$cbEast =$_POST["cbEast"];
$dateEast = $_POST["dateEast"];
$descEast = $_POST["descriptionEast"];
// West
$cbWest =$_POST["cbWest"];
$dateWest = $_POST["dateWest"];
$descWest = $_POST["descriptionWest"];
// North
$cbNorth =$_POST["cbNorth"];
$dateNorth = $_POST["dateNorth"];
$descNorth = $_POST["descriptionNorth"];
// South
$cbSouth =$_POST["cbSouth"];
$dateSouth = $_POST["dateSouth"];
$descSouth = $_POST["descriptionSouth"];


$direction = "";
$addingDate = "";
$photoSetID =0;
$imgDesc = "";

$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
$db="is5108group-4__digdata";

$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}

insertContext();
//echo $cbEast.$cbWest.$cbNorth.$cbSouth;
if(isset($cbEast)&&$cbEast=="on"){
	echo "cbEast";
	$direction = "East";
	$addingDate = $dateEast;
	$imgDesc = $descEast;
	uploadImg("imgsEast");
}
if(isset($cbWest)&&$cbWest=="on"){
	echo "cbWest";
	$direction = "West";
	$addingDate = $dateWest;
	$imgDesc = $descWest;
	uploadImg("imgsWest");
}
if(isset($cbNorth)&&$cbNorth=="on"){
	echo "cbNorth";
	$direction = "North";
	$addingDate = $dateNorth;
	$imgDesc = $descNorth;
	uploadImg("imgsNorth");
}
if(isset($cbSouth)&&$cbSouth=="on"){
	echo "cbSouth";
	$direction = "South";
	$addingDate = $dateSouth;
	$imgDesc = $descSouth;
	uploadImg("imgsSouth");
}



function uploadImg($id){
	global $photoSetID,$connect;

	insertPhotoSet();
	echo "<br>PhotoSetID:".$photoSetID."</br>";
	$target_dir = "../context images/";
	foreach($_FILES[$id]["name"] as $f => $name){
		$target_file = $target_dir . basename($_FILES[$id]["name"][$f]);
		$path = "context images/".basename($_FILES[$id]["name"][$f]);

		$uploadOK = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$check = getimagesize($_FILES[$id]["tmp_name"][$f]);
		 if($check !== false) {
			 echo $target_file;
			 echo "<br>".$path."<br>";
			 echo "File is an image - " . $check["mime"] . ".";
			 $sql = "INSERT INTO `Photos` (`FrameID`, `PhotoSetID`, `Directory Path`) VALUES (NULL, '$photoSetID', '$path')";
			 echo "<br>".$sql."<br>";
			 mysqli_query($connect,$sql);
			 $uploadOk = 1;
		 } else {
			 echo "File is not an image.";
			 $uploadOk = 0;
		 }

		if ($_FILES["fileToUpload"]["size"] > 8388608) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		else{
			$sql = "INSERT INTO `Photos` (`FrameID`, `PhotoSetID`, `Directory Path`) VALUES (NULL, '$photoSetID', '$path')";
			mysqli_query($connect,$sql);
		}
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
}


function insertPhotoSet(){
	global $site, $contextID, $trench, $connect, $direction, $addingDate, $photoSetID;
	$sql ="INSERT INTO `PhotoSets` (`PhotoSetID`, `SiteCode`, `Trench`, `Description`, `Direction`, `Date`)
	VALUES (NULL, '$site', '$trench', '$imgDesc', '$direction', '$addingDate')";
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
	//echo "<br>PhotoSetID:".$photoSetID."</br>";

	$sql = "INSERT INTO `PhotoSet-Context Links` (`LinkID`, `PhotoSetID`, `ContextID`) VALUES (NULL, '$photoSetID', '$contextID')";
	mysqli_query($connect,$sql);
	echo "<br>".$sql."<br>";


}

function insertContext(){
	global $site, $contextNum, $trench, $connect, $description, $interpretation;
	$sql = "INSERT INTO `is5108group-4__digdata`.Context_Records (`ContextID`, `SiteCode`, `Trench`, `ContextNum`, `Description`, `Interpretation`)
	VALUES (NULL,$site,'$trench',$contextNum,'$description', '$interpretation')";
	echo $sql;
	if ($connect->query($sql) === TRUE) {
		echo "New record created successfully";
		$_SESSION["addResult"] =  "A new context was added successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $connect->error;
		$_SESSION["addResult"] =  "Error can't add a new context";
	}



}


$connect->close();
header("Location:../add_context.php");
?>
