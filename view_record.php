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
    <h2>Find Name</h2>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>
                        <table class="table table-bordered noBottomMargin">
                            <tbody>
                            <tr>
                                <td><strong>Name: </strong><?php printf("%s", $row["Name"]) ?></td>
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
                            <tr>
                                <td><strong>Photo Description: </strong><?php printf("%s", $row["FDESC"]) ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-sm-6 col-md-2">
                    <div class="thumbnail">
                        <a href="#" class="pop">
                            <img src="https://png.icons8.com/metro/1600/batman-new.png" height="200" width="200">
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="thumbnail">
                        <a href="#" class="pop">
                            <img src="https://png.icons8.com/metro/1600/batman-new.png" height="200" width="200">
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="thumbnail">
                        <a href="#" class="pop">
                            <img src="https://png.icons8.com/metro/1600/batman-new.png" height="200" width="200">
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="thumbnail">
                        <a href="#" class="pop">
                            <img src="https://png.icons8.com/metro/1600/batman-new.png" height="200" width="200">
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="thumbnail">
                        <a href="#" class="pop">
                            <img src="https://png.icons8.com/metro/1600/batman-new.png" height="200" width="200">
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img src="" class="imagepreview" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>
                        <table class="table table-bordered noBottomMargin">
                            <tbody>
                            <tr>
                                <td><strong class="text-danger">CONTEXT (to be changed)</strong><?php printf("%s", $row["FindID"]) ?></td>
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
                            <tr>
                                <td><strong>Photo Description: </strong><?php printf("%s", $row["FDESC"]) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                                        Collapsible Group 1</a>
                                                </h4>
                                            </div>
                                            <div id="collapse1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                                            minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                                            commodo consequat.
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-2">
                                                            <div class="thumbnail">
                                                                <a href="#" class="pop">
                                                                    <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-2">
                                                            <div class="thumbnail">
                                                                <a href="#" class="pop">
                                                                    <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-2">
                                                            <div class="thumbnail">
                                                                <a href="#" class="pop">
                                                                    <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-2">
                                                            <div class="thumbnail">
                                                                <a href="#" class="pop">
                                                                    <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-2">
                                                            <div class="thumbnail">
                                                                <a href="#" class="pop">
                                                                    <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                                        Collapsible Group 2</a>
                                                </h4>
                                            </div>
                                            <div id="collapse2" class="panel-collapse collapse">
                                                <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                                    minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                                    commodo consequat.</div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                                        Collapsible Group 3</a>
                                                </h4>
                                            </div>
                                            <div id="collapse3" class="panel-collapse collapse">
                                                <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                                    minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                                    commodo consequat.</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</body>
</html>

<script>
    $(function () {
        $('.pop').on('click', function () {
            $('.imagepreview').attr('src', $(this).find('img').attr('src'));
            $('#imagemodal').modal('show');
        });
    });
</script>