<?php
session_start();
$frameID = $_GET['FrameID'];

include 'databaseConfig.php';

$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}


echo $frameID;

//deleteImg($frameID);


function deleteImg($frameID){

  global $connect;
  $photo_link_tb = "PhotoSet-Find Links";
  $photos_tb = "Photos";
  $photo_sets_tb = "PhotoSets";


  $sql = "SELECT * FROM `Photos` WHERE FrameID=$frameID";
  $photosQuery = $connect->query($sql);
  $row = $photosQuery->fetch_assoc();

  $sql = "SELECT * FROM $photos_tb WHERE PhotoSetID=".$row['PhotoSetID'];
  $photosQuery = $connect->query($sql);

  if($photosQuery -> num_rows > 1){
    $sql = "SELECT * FROM `Photos` WHERE FrameID=$frameID";
    $photosQuery = $connect->query($sql);
    $row = $photosQuery->fetch_assoc();
    echo unlink("../".$row["Directory Path"]);

    $sql = "DELETE FROM $photos_tb WHERE FrameID=$frameID";
    if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connect->error;
    }
  }

  else{
    $sql = "SELECT * FROM `Photos` WHERE FrameID=$frameID";
    $photosQuery = $connect->query($sql);
    $row = $photosQuery->fetch_assoc();
    $photoSetID = $row["PhotoSetID"];
    while($row = $photosQuery->fetch_assoc()) {
      echo unlink("../".$row["Directory Path"]);
    }

    $sql = "DELETE FROM `$photo_link_tb` WHERE PhotoSetID=$photoSetID";
    if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connect->error;
    }

    $sql = "DELETE FROM $photos_tb WHERE PhotoSetID=$photoSetID";
    if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connect->error;
    }

    $sql = "DELETE FROM $photo_sets_tb WHERE PhotoSetID=$photoSetID";
    if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connect->error;
    }


  }



}


?>
<html><head></head></html>
