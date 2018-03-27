<?php
session_start();
$findID = $_GET["id"];

$username = "is5108group-4";
$password = "b9iVc.9gS8c7NJ";
$host = "is5108group-4.host.cs.st-andrews.ac.uk";
$db = "is5108group-4__digdata";
$tb = "Finds";

$connect = mysqli_connect($host, $username, $password);
if (!$connect) {
    echo "Can't connect to SQLdatabase ";
    exit();
} else {
    mysqli_select_db($connect, $db) or die("Can't select Database");
    //SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM Finds INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode ORDER BY `Date` DESC
    $find = mysqli_query($connect, "SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM $tb INNER JOIN Context_Records cr
      ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode WHERE $tb.FindID = $findID");
    $row = mysqli_fetch_array($find, MYSQLI_ASSOC);
    //echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
    //echo $found;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DigData</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"
            integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ"
            crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><i class="fas fa-paint-brush"></i>&nbsp;DigData</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="add_record.php">Add Record</a></li>
                <li><a href="search.php">Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><?php
                    include 'PHP/LoginButton.php';
                    ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container" style="margin-top:50px">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td width="100">
                        <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100"
                             class="center-block" alt="Cinque Terre">
                    </td>
                    <td>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td><strong>ID: </strong><?php printf("%s", $row["FindID"]) ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Location: </strong><?php printf("%s", $row["SiteName"]) ?>
                                    <strong>Founder: </strong><?php printf("%s", $row["UserID"]) ?>
                                    <strong>Date: </strong><?php printf("%s", $row["Date"]) ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Description: </strong><?php printf("%s", $row["FDESC"]) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Lorem ipsum donec id elit non mi porta gravida at eget metus.</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
