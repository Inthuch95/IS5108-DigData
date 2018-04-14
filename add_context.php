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

    ///  $found = mysqli_num_rows($find);
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
        var numEast = 0;
        var numWest = 0;
        var numNorth = 0;
        var numSouth = 0;
        var butID = "";

        var num;
        function moreImage(id) {
            console.log("more image box" + id);
            switch (id) {
                case "imgsEast":
                    butID = "moreImgEast" + numEast;
                    numEast++;
                    num = numEast;
                    break;
                case "imgsWest":
                    butID = "moreImgWest" + numWest;
                    numWest++;
                    num = numWest;
                    break;
                case "imgsNorth":
                    butID = "moreImgNorth" + numNorth;
                    numNorth++;
                    num = numNorth;
                    break;
                case "imgsSouth":
                    butID = "moreImgSouth" + numSouth;
                    numSouth++;
                    num = numSouth;
                    break;
            }
            $("#" + id + " .panel-body").append('\
              <div class="form-group" id="' + butID + '-form">\
                <label class="control-label col-sm-2" for="">Image ' + (num + 1) + '.</label>\
                <div class="col-sm-4">\
                  <input class="form-control" accept="image/*" onchange="checkSize(this)"  type="file" name="\' + id + \'[]">\
                </div>\
                <div class="col-sm-1">\
                  <button type="button" class="btn btn-danger pull-right" id=\' + butID + \' onclick=removeImg("' + butID +'-form") >\
                    <i class="fas fa-trash-alt"></i>\
                  </button>\
                </div>\
              </div>\
	        ');

        }

        function removeImg(id) {
            console.log("remove " + id);
            $("#" + id).remove();
        }

		function checkSize(input){
			if(input.files[0].size>8388608){
				input.value="";
				alert('This file is too large');
			}
		}
        function showUploadBox(thisID, showid) {

            if ($("#" + thisID).is(":checked")) {
                $("#" + showid).show();
            }
            else {
                $("#" + showid).hide();
            }
        }
    </script>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" data-toggle="validator" role="form" action="PHP/insertContext.php"
                              method='post' enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="location">Location*</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="location" placeholder="Select location" name="site"
                                            onchange="showTrench_AddContext(this.value)" required>
                                        <option value="">Select a site</option>
                                        <?php
                                        $find = mysqli_query($connect, "SELECT * FROM $tb");
                                        while ($row = mysqli_fetch_array($find, MYSQLI_ASSOC)) {
                                            print '<option value="' . $row["SiteCode"] . '">' . $row["SiteCode"] . " - " . $row["SiteName"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-sm-2" for="trench">Trench*</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="trench" name="trench"
                                            onchange="showNewTrench_Addcontext(this.value)" disabled required>
                                        <option value="">Select site first</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="newTrench" hidden>
                                <label class="control-label col-sm-2"></label>
                                <div class="col-sm-3">
                                    <input class="form-control" type="" name="newTrench" id="newTrenchInput" value=""
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="context">Context*</label>
                                <div class="col-sm-3">
                                    <input class="form-control" name="contextNum" id="context" value="Select site first"
                                           readonly>
                                    <?php
                                    $find = mysqli_query($connect, "SELECT MAX(ContextID) AS maxContextID FROM Context_Records");
                                    $row = mysqli_fetch_array($find, MYSQLI_ASSOC);
                                    $num = intval($row["maxContextID"] + 1);
                                    ?>
                                    <input type="hidden" class="form-control" name="contextID" id="contextID"
                                           value="<?php echo $num ?>">
                                </div>
                            </div>


                            <div class="form-group has-feedback">
                                <label class="control-label col-sm-2" for="description">Description*</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="5" id="description" name="description"
                                              required></textarea>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label col-sm-2" for="interpretation">Interpretation*</label>
                                <div class="col-sm-3">
                                    <input class="form-control" id="Interpretation" name="Interpretation" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="fileToUpload">Uploaded image(s)</label>
                                <div class="col-sm-10">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="cbEast" id="cbEast"
                                                      onchange=showUploadBox(this.id,"imgsEast")>East
                                        </label>
                                        <div id="imgsEast" hidden>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="descriptionEast">Description</label>
                                                                <div class="col-sm-7">
                                                                        <textarea class="form-control" rows="5"
                                                                                  id="descriptionEast"
                                                                                  name="descriptionEast"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="date">Date</label>
                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                               name="dateEast"
                                                                               id="dateEast"
                                                                               value="<?php echo date('Y-m-d'); ?>">
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-default"
                                                                                    type="button"
                                                                                    id="dateEast-butt">
                                                                                <i class="far fa-calendar-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="">Image 1.</label>
                                                                <div class="col-sm-4">
                                                                    <input class="form-control" accept="image/*" onchange="checkSize(this)"  type="file"
                                                                           name="imgsEast[]">
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <button type="button"
                                                                            class="btn btn-success pull-right"
                                                                            onclick=moreImage("imgsEast")>
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="cbWest" id="cbWest"
                                                      onchange=showUploadBox(this.id,"imgsWest")>West
                                        </label>
                                        <div id="imgsWest" hidden>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="descriptionWest">Description</label>
                                                                <div class="col-sm-7">
                                                                        <textarea class="form-control" rows="5"
                                                                                  id="descriptionWest"
                                                                                  name="descriptionWest"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="date">Date</label>
                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                               name="dateWest"
                                                                               id="dateWest"
                                                                               value="<?php echo date('Y-m-d'); ?>">
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-default"
                                                                                    type="button"
                                                                                    id="dateWest-butt">
                                                                                <i class="far fa-calendar-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="">Image 1.</label>
                                                                <div class="col-sm-4">
                                                                    <input class="form-control" accept="image/*" onchange="checkSize(this)"  type="file"
                                                                           name="imgsWest[]">
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <button type="button"
                                                                            class="btn btn-success pull-right"
                                                                            onclick=moreImage("imgsWest")>
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="cbNorth" id="cbNorth"
                                                      onchange=showUploadBox(this.id,"imgsNorth")>North
                                        </label>
                                        <div id="imgsNorth" hidden>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="descriptionNorth">Description</label>
                                                                <div class="col-sm-7">
                                                                        <textarea class="form-control" rows="5"
                                                                                  id="descriptionNorth"
                                                                                  name="descriptionNorth"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="date">Date</label>
                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                               name="dateNorth"
                                                                               id="dateNorth"
                                                                               value="<?php echo date('Y-m-d'); ?>">
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-default"
                                                                                    type="button"
                                                                                    id="dateNorth-butt">
                                                                                <i class="far fa-calendar-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="">Image 1.</label>
                                                                <div class="col-sm-4">
                                                                    <input class="form-control" accept="image/*" onchange="checkSize(this)"  type="file"
                                                                           name="imgsNorth[]">
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <button type="button"
                                                                            class="btn btn-success pull-right"
                                                                            onclick=moreImage("imgsNorth")>
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="cbSouth" id="cbSouth"
                                                      onchange=showUploadBox(this.id,"imgsSouth")>South
                                        </label>
                                        <div id="imgsSouth" hidden>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="descriptionSouth">Description</label>
                                                                <div class="col-sm-7">
                                                                        <textarea class="form-control" rows="5"
                                                                                  id="descriptionSouth"
                                                                                  name="descriptionSouth"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="date">Date</label>
                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                               name="dateSouth"
                                                                               id="dateSouth"
                                                                               value="<?php echo date('Y-m-d'); ?>">
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-default"
                                                                                    type="button"
                                                                                    id="dateSouth-butt">
                                                                                <i class="far fa-calendar-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-2"
                                                                       for="">Image 1.</label>
                                                                <div class="col-sm-4">
                                                                    <input class="form-control" accept="image/*" onchange="checkSize(this)"  type="file"
                                                                           name="imgsSouth[]">
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <button type="button"
                                                                            class="btn btn-success pull-right"
                                                                            onclick=moreImage("imgsSouth")>
                                                                        <i class="fas fa-plus"></i>
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
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success pull-right"><i
                                                class="fas fa-upload"></i>&nbsp;Submit
                                    </button>
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
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {


        ?>
        <h2>You are not allowed to access to this page</h2>
        <?php
    }    //INSERT INTO `Site` (`SiteCode`, `SiteName`, `Description`) VALUES (NULL, 'Olympus', 'This is where the gods live');


    ?>


</div>

</body>
</html>


<script type="text/javascript">
    $(function () {
        $('#dateEast').datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $("#dateEast-butt").click(function () {
            $('#dateEast').datepicker("show");
        });

        $('#dateWest').datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $("#dateWest-butt").click(function () {
            $('#dateWest').datepicker("show");
        });

        $('#dateNorth').datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $("#dateNorth-butt").click(function () {
            $('#dateNorth').datepicker("show");
        });

        $('#dateSouth').datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $("#dateSouth-butt").click(function () {
            $('#dateSouth').datepicker("show");
        });
    });
</script>