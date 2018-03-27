<?php
session_start();
$site = $_GET["site"];
if ($_GET["trench"] == "New trench"){
  $trench = $_GET["newTrench"];
} else {
  $trench = $_GET["trench"];
}
$description = $_GET["description"];

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
$sql = "INSERT INTO `is5108group-4__digdata`.Context_Records (ContextID,SiteCode,Trench,Description) VALUES (NULL,$site,'".$trench."','".$description."')";
if ($connect->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}
$connect->close();
$_SESSION["addResult"] =  "A new context was added successfully";
header("Location:../add_context.php");
?>
