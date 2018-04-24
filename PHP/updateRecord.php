<?php
session_start();
$findID = intval($_GET["FindID"]);
$contextID=$_GET["context"];
$date=$_GET["date"];
$lastModified = date("Y-m-d");
$type=$_GET["type"];
$name = $_GET["name"];
$description=$_GET["description"];
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
$connect->close();

$prevPage = $_SESSION["currentPage"];
$_SESSION["currentPage"] ='';
//echo $prevPage;
header("Location:../".$prevPage);
//header("Location:../index.php");
?>
