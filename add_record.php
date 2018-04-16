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
    //echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
    //echo $found;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DigData - Add New Record</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    <script src="Script/Script.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"
            integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ"
            crossorigin="anonymous"></script>

    <script>

        function checkSize(input) {
            if (input.files[0].size > 8388608) {
                input.value = "";
                alert('This file is too large');
            }
        }

        var numPic = 0;

        function moreImage(id) {
            butID = "moreImg" + numPic;
            numPic++;
            console.log("more image box: " + id);

            $('<div class="form-group" id="' + butID + '-form">\
                <label class="control-label col-sm-1" for="" style="padding-top: 2px"><i class="fas fa-file-image fa-2x"></i></label>\
                <div class="col-sm-4">\
                  <input class="form-control" accept="image/*" onchange="checkSize(this)"  type="file" name="\' + id + \'[]">\
                </div>\
                <div class="col-sm-1">\
                  <button type="button" class="btn btn-danger pull-right" id=\' + butID + \' onclick=removeImg("' + butID + '-form") >\
                    <i class="fas fa-trash-alt"></i>\
                  </button>\
                </div>\
              </div>\
	        ').insertBefore("#imgs .add-butt-form");

        }

        function removeImg(id) {
            console.log("remove" + id);
            $("#" + id).remove();

        }

        function showUploadBox(thisID, showid) {

            if ($("#" + thisID).is(":checked")) {
                $("#" + showid).show();
            }
            else {
                $("#" + showid).hide();
            }
        }</script>
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
                <li class="active"><a href="add_record.php">Add Record</a></li>
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
    <h2>Add record</h2>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" data-toggle="validator" method="post" role="form"
                          action="PHP/addRecord.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="finder">Finder</label>
                            <div class="col-sm-3">
                                <?php
                                if (isset($_SESSION['user']) and $_SESSION['user'] != '') {
                                    print '<input class="form-control" type="" value="' . $_SESSION["user"] . '" readonly>';
                                    print '<input class="form-control" type="hidden" name="user" value="' . $_SESSION["UserID"] . '" display="">';
                                } else {
                                    $_SESSION['loginerror'] = "You have to login first";
                                    $_SESSION["currentPage"] = basename($_SERVER['PHP_SELF']);

                                    header("Location:login.php");
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="location">Location*</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="location" placeholder="Select location" name="site"
                                        onchange="showTrench(this.value)" required>
                                    <option value="">Select a site</option>
                                    <?php
                                    while ($row = mysqli_fetch_array($find, MYSQLI_ASSOC)) {
                                        print '<option value="' . $row["SiteCode"] . '">' . $row["SiteCode"] . " - " . $row["SiteName"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="trench">Trench*</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="trench" name="trench"
                                        onchange="showContext(this.value)" disabled='true' required>
                                    <option value="">Select site first</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="context">Context*</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="context" name="contextID"
                                        onchange="showContextDesc(this.value)" disabled='true' required>
                                    <option value="">Select site first</option>
                                </select>
                                <h5 class="text-info" id="contextDesc" hidden></h5>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="date">From*</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="date" id="date"
                                           value="<?php echo date('Y-m-d'); ?>" required>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="date-butt">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="type">Type*</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="type" name="type" required>
                                    <option value="Metal">Metal</option>
                                    <option value="Wood">Wood</option>
                                    <option value="Baked">Baked clay</option>
                                    <option value="Stone">Stone</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="description">Description*</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="description" name="description"
                                          data-error="Please fill in this field" required></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="fileToUpload">Uploaded image(s)</label>
                            <div class="col-sm-10">
                                <div id="imgs">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-1"
                                                               for="" style="padding-top: 2px"><i
                                                                    class="fas fa-file-image fa-2x"></i></label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" accept="image/*"
                                                                   onchange="checkSize(this)" type="file"
                                                                   name="imgs[]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group add-butt-form">
                                                        <div class="col-sm-offset-1 col-sm-4">
                                                            <button type="button"
                                                                    class="btn btn-success btn-block"
                                                                    onclick=moreImage("imgs")>
                                                                <i class="fas fa-plus"></i>&nbsp;Another Image
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success pull-right"><i class="fas fa-upload"></i>&nbsp;Submit
                                </button>
                                <div id="addResult"><?php
                                    if (isset($_SESSION["addResult"]) and $_SESSION["addResult"] != "") {
                                        print $_SESSION["addResult"];
                                        $_SESSION["addResult"] = "";
                                    }
                                    ?>
                                </div>
                            </div>`
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
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $("#date-butt").click(function () {
            $('#date').datepicker("show");
        });
    });
</script>