<?php
session_start();
$findID = intval($_GET["FindID"]);
$contextID=$_GET["context"];
$date=$_GET["date"];
$lastModified = date("Y-m-d");
$type=$_GET["type"];
$name = $_GET["name"];
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

$sql = "UPDATE $tb SET ContextID=?, Description=?, Type=?, Date=?, Name=?, LastModified=?, ModifiedBy=? WHERE FindID=$findID";

$stmt = $connect->prepare($sql);  //prepares the query for action
$stmt->bind_param("issssss", $contextID, $description, $type, $date, $name, $lastModified, $_SESSION['user']);    



if ($stmt->execute() === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $connect->error;
}
$connect->close();
header("Location:../index.php");
?>
