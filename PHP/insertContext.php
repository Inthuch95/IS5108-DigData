<?php
session_start();
$site = $_POST["site"];
if ($_POST["trench"] == "New trench"){
  $trench = $_POST["newTrench"];
} else {
  $trench = $_POST["trench"];
}
$contextNum = $_POST["contextNum"];
$description = $_POST["description"];
$cbEast =$_POST["cbEast"];
$cbWest =$_POST["cbWest"];
$cbNorth =$_POST["cbNorth"];
$cbSouth =$_POST["cbSouth"];

//echo $cbEast.$cbWest.$cbNorth.$cbSouth;
if(isset($cbEast)&&$cbEast=="on"){
	echo "cbEast";
	uploadImg("imgsEast");
}
if(isset($cbWest)&&$cbWest=="on"){
	echo "cbWest";
	uploadImg("imgsWest");
}
if(isset($cbNorth)&&$cbNorth=="on"){
	echo "cbNorth";
	uploadImg("imgsNorth");
}
if(isset($cbSouth)&&$cbSouth=="on"){
	echo "cbSouth";
	uploadImg("imgsSouth");
}



function uploadImg($id){
	$target_dir = "../context images/";
	foreach($_FILES[$id]["name"] as $f => $name){
		$target_file = $target_dir . basename($_FILES[$id]["name"][$f]);
		echo $target_file;
		$uploadOK = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$check = getimagesize($_FILES[$id]["tmp_name"][$f]);
		 if($check !== false) {
			 echo "File is an image - " . $check["mime"] . ".";
			 $uploadOk = 1;
		 } else {
			 echo "File is not an image.";
			 $uploadOk = 0;
		 }

		// Check if file already exists
		if (file_exists($target_file)) {
		   echo "Sorry, file already exists.";
		   $uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES[$id]["tmp_name"][$f], $target_file)) {
				echo "The file ". basename( $_FILES[$id]["name"][$f]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
	}
}


$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
$db="is5108group-4__digdata";
$tb = "Context_Records";

$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}
$sql = "INSERT INTO `is5108group-4__digdata`.Context_Records (ContextID,SiteCode,Trench,ContextNum,Description) VALUES (NULL,$site,'".$trench."',".$contextNum.",'".$description."')";
/*
if ($connect->query($sql) === TRUE) {
    echo "New record created successfully";
	$_SESSION["addResult"] =  "A new context was added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
	$_SESSION["addResult"] =  "Error can't add a new context";
}
*/

$connect->close();

#header("Location:../add_context.php");
?>
