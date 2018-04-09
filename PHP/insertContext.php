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
$target_dir = "../context images/";

foreach($_FILES["fileToUpload"]["name"] as $f => $name){
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$f]);
    $uploadOK = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$f]);
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
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$f], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"][$f]). " has been uploaded.";
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
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}*/
$connect->close();
$_SESSION["addResult"] =  "A new context was added successfully";
#header("Location:../add_context.php");
?>
