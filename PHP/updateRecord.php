<?php
session_start();
$findID = intval($_POST["FindID"]);
$site=$_POST["site"];
$trench=$_POST["trench"];
$contextID=$_POST["context"];
$date=$_POST["date"];
$lastModified = date("Y-m-d");
$type=$_POST["type"];
$name = $_POST["name"];
$description=$_POST["description"];
$photoSetID =0;
include 'databaseConfig.php';

$tb = "Finds";

$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}

$sql = "UPDATE $tb SET ContextID=?, Description=?, Type=?, Date=?, Name=?, LastModified=?, ModifiedBy=? WHERE FindID=$findID";

$stmt = $connect->prepare($sql);  //prepares the query for action
$stmt->bind_param("issssss", $contextID, $description, $type, $date, $name, $lastModified, $_SESSION['user']);    

if ($stmt->execute() === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $connect->error;
}

uploadImg("imgs");

function uploadImg($id){
	global $photoSetID,$connect,$findID;

	print_r($_FILES[$id]);
	if (isset($_FILES[$id]) && $_FILES[$id]['error'] != UPLOAD_ERR_NO_FILE && $_FILES[$id]["name"][0] != '')
	{
		$sql = "SELECT * FROM  `PhotoSet-Find Links`  WHERE FindID=$findID";
		$photoSetQuery = $connect->query($sql);
		if($photoSetQuery -> num_rows >0){
			$photoSetData = $photoSetQuery->fetch_assoc();
			$photoSetID = $photoSetData["PhotoSetID"];
			uploadEachImg($id);
		}
		else{
			insertPhotoSet();
			uploadEachImg($id);
		}
	}
}

function uploadEachImg($id){
	global $photoSetID,$connect,$findID;
	
	echo "<br>PhotoSetID:".$photoSetID."</br>";
	$target_dir = "../record images/";

	foreach($_FILES[$id]["name"] as $f => $name){
		$target_file = $target_dir .$findID."_".basename($_FILES[$id]["name"][$f]);
		$path = "record images/".$findID."_".basename($_FILES[$id]["name"][$f]);

		$uploadOK = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$check = getimagesize($_FILES[$id]["tmp_name"][$f]);
		 if($check !== false) {
			 /*2018-04-23
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
		echo $sql;
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
}

function insertPhotoSet(){
	global $site, $trench,$contextID, $connect, $direction, $date, $photoSetID, $findID;
	$sql ="INSERT INTO `PhotoSets` (`PhotoSetID`, `SiteCode`, `Trench`, `Description`, `Direction`, `Date`)
	VALUES (NULL, '$site', '$trench', 'This photo set belongs to FindID:$findID', '', '$date')";
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
	$sql = "INSERT INTO `PhotoSet-Find Links` (`LinkID`, `PhotoSetID`, `FindID`) VALUES (NULL, '$photoSetID', '$findID')";
	mysqli_query($connect,$sql);
	echo "<br>".$sql."<br>";


}


$connect->close();

$prevPage = $_SESSION["currentPage"];
$_SESSION["currentPage"] ='';
//echo $prevPage;
header("Location:../".$prevPage);
?>
