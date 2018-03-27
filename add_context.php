<?php
session_start();
$_SESSION["currentPage"] = '';
$username = "is5108group-4";
$password = "b9iVc.9gS8c7NJ";
$host = "is5108group-4.host.cs.st-andrews.ac.uk";
$db = "is5108group-4__digdata";
$tb = "Site";

$connect = mysqli_connect($host, $username, $password);
if (!$connect) {
    echo "Can't connect to SQLdatabase ";
    exit();
} else {
    mysqli_select_db($connect, $db) or die("Can't select Database");
    //SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM Finds INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode ORDER BY `Date` DESC
    $find = mysqli_query($connect, "SELECT * FROM $tb");
    $found = mysqli_num_rows($find);
    //new branch
    //echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
    //echo $found;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DigData - Add New Context</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="Script/Script.js"></script>
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
    <?php
    if (isset($_SESSION['admin']) and $_SESSION['admin'] == true) {
        ?>
        <h2>Add new context</h2>
        <form class="form-horizontal" action="PHP/insertContext.php">
            <div class="form-group">
                <label class="control-label col-sm-2" for="location">Location:</label>
                <div class="col-sm-4">
                    <select class="form-control" id="location" placeholder="Select location" name="site"
                            onchange="showTrench_AddContext(this.value)">
                        <option value="">Select a site</option>
                        <?php
                        while ($row = mysqli_fetch_array($find, MYSQLI_ASSOC)) {
                            print '<option value="' . $row["SiteCode"] . '">' . $row["SiteCode"] . " - " . $row["SiteName"] . '</option>';
                        }
                        ?>

                    </select>

                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-sm-2" for="trench">Trench:</label>
                <div class="col-sm-4">
                    <select class="form-control" id="trench" name="trench"
                            onchange="showNewTrench_Addcontext(this.value)">
                        <option value="">Select Site first</option>
                    </select>

                </div>
            </div>

            <div class="form-group" id="newTrench" hidden>
                <label class="control-label col-sm-2"></label>
                <div class="col-sm-4">
                    <input class="form-control" type="" name="newTrench" value="">


                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-sm-2" for="context">Context:</label>
                <div class="col-sm-4">
                    <?php
                    $find = mysqli_query($connect, "SELECT MAX(ContextID) as maxID FROM Context_Records ");
                    $row = mysqli_fetch_array($find, MYSQLI_ASSOC);
                    $id = intval($row["maxID"]) + 1;

                    print '<input class="form-control" type="" name="context"value="' . $id . '" readonly>';
                    ?>

                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-sm-2" for="description">Description:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
                <div id="addResult">
                    <?php
                    if (isset($_SESSION["addResult"]) and $_SESSION["addResult"] != "") {
                        print $_SESSION["addResult"];
                        $_SESSION["addResult"] = "";
                    }
                    ?>
                </div>
            </div>

        </form>
        <?php
    } else {


        ?>
        <h2>You are not allowed on this page</h2>
        <?php
    }    //INSERT INTO `Site` (`SiteCode`, `SiteName`, `Description`) VALUES (NULL, 'Olympus', 'This is where the gods live');


    ?>


</div>

</body>
</html>
