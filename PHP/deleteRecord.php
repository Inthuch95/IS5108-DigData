<?php
session_start();
$_SESSION["currentPage"] = '';
if (isset($_SESSION['user']) and $_SESSION['user'] != '') {
  if (isset($_GET["id"])) {
    $_SESSION["currentID"] = intval($_GET["id"]);
  }
  $findID = $_SESSION["currentID"];
  $username="is5108group-4";
  $password="b9iVc.9gS8c7NJ";
  $host="is5108group-4.host.cs.st-andrews.ac.uk";
  $db="is5108group-4__digdata";
  $finds_tb = "Finds";
  $photo_link_tb = "PhotoSet-Find Links";
  $photos_tb = "Photos";
  $photo_sets_tb = "PhotoSets";

  $connect = new mysqli($host, $username, $password, $db);
  // Check connection
  if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
  }

  $sql = "SELECT * FROM  `$photo_link_tb`  WHERE FindID=$findID";
  $photoSetQuery = $connect->query($sql);
  $photoSetData = $photoSetQuery->fetch_assoc();
  $photoSetID = $photoSetData["PhotoSetID"];

  $sql = "SELECT * FROM  $photos_tb  WHERE PhotoSetID=$photoSetID";
  $photosQuery = $connect->query($sql);
  while($row = $photosQuery->fetch_assoc()) {
    echo unlink("../".$row["Directory Path"]);
  }

  $sql = "DELETE FROM `$photo_link_tb` WHERE FindID=$findID";
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

  $sql = "DELETE FROM $finds_tb WHERE FindID=$findID";
  if ($connect->query($sql) === TRUE) {
      echo "Record updated successfully";
  } else {
      echo "Error updating record: " . $connect->error;
  }
  $connect->close();
  $prevPage = $_SESSION["currentPage"];
  $_SESSION["currentPage"] ="";
  header("Location:../".$prevPage);
} else {
  $_SESSION["currentID"] = intval($_GET["id"]);
  $_SESSION['loginerror'] = "You have to login first";
  $_SESSION["currentPage"] = "index.php";
  header("Location:../login.php");
}
?>
