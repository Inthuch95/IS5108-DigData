<?php
session_start();
$findID = intval($_GET["FindID"]);
$contextID=$_GET["context"];
$date=$_GET["date"];
$lastModified = date("Y-m-d");
$type=$_GET["type"];
$description=$_GET["description"];
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
$sql = "UPDATE $tb SET ContextID='".$contextID."', Description='".$description."', Type='".$type."', Date='".$date."',
LastModified='".$lastModified."', ModifiedBy='".$_SESSION['user']."' WHERE FindID=$findID";

if ($connect->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $connect->error;
}
$connect->close();
header("Location:../index.php");
?>
