<?php
session_start();
$_SESSION["currentPage"] = '';
$findID = 0;
if (isset($_SESSION['user']) and $_SESSION['user'] != '') {
  if (isset($_GET["id"])) {
    $_SESSION["currentID"] = intval($_GET["id"]);
  }
  $findID = $_SESSION["currentID"];
} else {
  $_SESSION["currentID"] = intval($_GET["id"]);
  $_SESSION['loginerror'] = "You have to login first";
  $_SESSION["currentPage"] = basename($_SERVER['PHP_SELF']);
  header("Location:login.php");
}
$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
$db="is5108group-4__digdata";
$recordTB = "Finds";
$siteTB = "Site";
$userTB = "Users";

$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}
$recordSQL = "SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM $recordTB INNER JOIN Context_Records cr
  ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode WHERE $recordTB.FindID = $findID";
$sitesSQL = "SELECT * FROM $siteTB";
$record = $connect->query($recordSQL);
$sites = $connect->query($sitesSQL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DigData - Edit Record</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="Script/Script.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
    <h2>Edit record</h2>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" action="PHP/updateRecord.php">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="finder">Finder:</label>
                            <div class="col-sm-3">
                                <?php
                                $currentRecord = $record->fetch_assoc();
                                $LOGusername = $currentRecord["UserID"];
                                $userSQL = "SELECT * FROM $userTB WHERE UserID='$LOGusername'";
                                $user = $connect->query($userSQL);
                                $currentUser = $user->fetch_assoc();
                                if (isset($_SESSION['user']) and $_SESSION['user'] != '') {

                                    print '<input class="form-control" type="" value="' . $currentUser["Username"] . '" readonly>';
                                    print '<input class="form-control" type="hidden" name="user" value="' . $currentUser["UserID"] . '" display="">';
                                    print '<input class="form-control" type="hidden" name="FindID" value="' . $currentRecord["FindID"] . '" display="">';
                                } else {
                                    $_SESSION['loginerror'] = "You have to login first";
                                    $_SESSION["currentPage"] = basename($_SERVER['PHP_SELF']);

                                    header("Location:login.php");
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="location">Location:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="location" placeholder="Select location" name="site"
                                        onchange="showTrench(this.value)">
                                    <option value="">Select a site</option>
                                    <?php
                                    $_SESSION['currentTrench'] = $currentRecord["Trench"];
                                    $_SESSION['currentContext'] = $currentRecord["ContextID"];
                                    while ($row = $sites->fetch_assoc()) {
                                        if ($row["SiteCode"] == $currentRecord["SiteCode"]) {
                                            print '<option selected="selected" value="' . $row["SiteCode"] . '">' . $row["SiteCode"] . " - " . $row["SiteName"] . '</option>';
                                        } else{
                                            print '<option value="' . $row["SiteCode"] . '">' . $row["SiteCode"] . " - " . $row["SiteName"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="trench">Trench:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="trench" name="trench"
                                        onchange="showContext(this.value)" disabled='true'>
                                    <option value="">Select site first</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="context">Context:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="context" name="context"
                                        onchange="showContextDesc(this.value)" disabled='true'>
                                    <option value="">Select site first</option>
                                </select>
                                <div id="contextDesc" hidden></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date">From:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="date" id="date"
                                           value="<?php echo date('Y-m-d'); ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="date-butt">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="type">Type:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="type" name="type">
                                    <option value="Metal">Metal</option>
                                    <option value="Wood">Wood</option>
                                    <option value="Rock">Rock</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success pull-right"><i class="fas fa-upload"></i>&nbsp;Submit</button>
                                <div id="addResult"><?php
                                    if (isset($_SESSION["addResult"]) and $_SESSION["addResult"] != "") {
                                        print $_SESSION["addResult"];
                                        $_SESSION["addResult"] = "";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    mysqli_close($connect);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<script type="text/javascript">
    $(function () {
        $('#date').datepicker({
            maxDate: 0
        });
        $("#date-butt").click(function () {
            $('#date').datepicker("show");
        });
        var currentTrench = <?php echo json_encode($currentRecord["Trench"]); ?>;
        var date = "<?php echo $currentRecord["Date"]; ?>";
        var type = "<?php echo $currentRecord["Type"]; ?>";
        var description = "<?php echo $currentRecord["FDESC"]; ?>";
        showTrench(document.getElementById("location").value);
        showContext(currentTrench);
        $('#date').val(date);
        $('#type').val(type);
        $('#description').val(description);
    });
</script>
