<?php
session_start();
$_SESSION["currentPage"] = '';
if (isset($_SESSION['user']) and $_SESSION['user'] != '') {
  if (isset($_GET["id"])) {
    $_SESSION["currentID"] = intval($_GET["id"]);
  }
  $findID = $_SESSION["currentID"];
} else {
  $_SESSION["currentID"] = intval($_GET["id"]);
  $_SESSION['loginerror'] = "You have to login first";
  $_SESSION["currentPage"] = "index.php";
  header("Location:../login.php");
}
if (isset($_SESSION['user']) and $_SESSION['user'] != '') {
  $username="is5108group-4";
  $password="b9iVc.9gS8c7NJ";
  $host="is5108group-4.host.cs.st-andrews.ac.uk";
  $db="is5108group-4__digdata";
  $tb = "Finds";

  $connect = new mysqli($host, $username, $password, $db);
  // Check connection
  if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
  }
  $sql = "DELETE FROM $tb WHERE FindID=$findID";

  if ($connect->query($sql) === TRUE) {
      echo "Record updated successfully";
  } else {
      echo "Error updating record: " . $connect->error;
  }
  $connect->close();
  header("Location:../index.php");
}
?>
