<?php
session_start();

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
$contextTB = "Context_Records";

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
$currentRecord = $record->fetch_assoc();
$currentSite = $currentRecord["SiteCode"];
$trenchSQL = "SELECT Distinct Trench FROM $contextTB WHERE SiteCode=$currentSite";
$trench = $connect->query($trenchSQL);
$currentTrench = $currentRecord["Trench"];
$currentContext = $currentRecord["ContextID"];
$contextSQL = "SELECT * FROM $contextTB WHERE SiteCode=$currentSite and Trench='".$currentTrench."'";
$context =  $connect->query($contextSQL);
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
              <input class="form-control" accept="image/*" onchange="checkSize(this)"  type="file" name="' + id + '[]">\
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

    function deleteByFrameID(FrameID){
      var xhttp;

      if(confirm("Are you sure?")){

        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();

        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }


        xmlhttp.onreadystatechange = function() {

          if (this.readyState == 4 && this.status == 200) {
            //alert(this.responseText);
            if(this.responseText.includes("hidden")){
              $("#imgPanel").hide();
            }else{
              $("#"+FrameID).hide();
            }
          }
        };

        xmlhttp.open("GET", "PHP/deleteSpecificImg.php?FrameID="+FrameID, true);
        xmlhttp.send();
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
    <h2>Edit record</h2>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="PHP/updateRecord.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="finder">Finder:</label>
                            <div class="col-sm-3">
                                <?php
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
                            <label class="control-label col-sm-2" for="finder">Artifact name:</label>
                            <div class="col-sm-3">
                               <input class="form-control" name="name" value="<?php echo $currentRecord['Name']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="location">Location:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="location" placeholder="Select location" name="site"
                                        onchange="showTrench(this.value)">
                                    <option value="">Select a site</option>
                                    <?php
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
                                        onchange="showContext(this.value)">
                                        <option value="">Select trench</option>
                                        <?php
                                        while ($row=$trench->fetch_assoc()) {
                                    			if ($currentTrench == $row["Trench"]) {
                                    					echo '<option selected="selected" value="'.$row["Trench"].'">'.$row["Trench"].'</option>';
                                    			} else {
                                    					echo '<option value="'.$row["Trench"].'">'.$row["Trench"].'</option>';
                                    			}
                                    		}
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="context">Context:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="context" name="context"
                                        onchange="showContextDesc(this.value)">
                                        <option value="">Select context</option>
                                        <?php
                                        while ($row=$context->fetch_assoc()) {
                                          if ($currentContext == $row["ContextID"]) {
                                    					echo '<option selected="selected" value="'.$row["ContextID"].'">'.$row["ContextNum"].'</option>';
                                    			} else {
                                    					echo '<option value="'.$row["ContextID"].'">'.$row["ContextNum"].'</option>';
                                    			}
                                    		}
                                        ?>
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

                            <?php
                            $sql = "SELECT * FROM `PhotoSet-Find Links` as link
                            INNER JOIN PhotoSets ps on link.PhotoSetID = ps.PhotoSetID
                            INNER JOIN Photos ph on ph.PhotoSetID = ps.PhotoSetID
                            where FindID = ".$currentRecord['FindID'].";";

                            $find2 = mysqli_query($connect, $sql);
                            if(mysqli_num_rows($find2)>0){
                              echo '<div class="form-group" id="imgPanel">
                                <div class="row">
                                <label class="control-label col-sm-2" >Images:</label>';

                              while ($row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC)){
                                print '<div class="col-sm-6 col-md-2" id='.$row2['FrameID'].'>
                                      <div class="thumbnail">
                                      <button class="btn btn-danger pull-right" type="button" value="'.$row2['FrameID'].'" onclick="deleteByFrameID(this.value)">X</button>
                                        <a href="#" class="pop">

                                              <img src="'.$row2['Directory Path'].'" height="200" width="200">
                                          </a>

                                      </div>
                                  </div>';

                              }

                              echo "</div>
                              </div>";

                            }

                            ?>

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
			dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $("#date-butt").click(function () {
            $('#date').datepicker("show");
        });
        var date = "<?php echo $currentRecord["Date"]; ?>";
        var type = "<?php echo $currentRecord["Type"]; ?>";
        var description = "<?php echo $currentRecord["FDESC"]; ?>";
        $('#date').val(date);
        $('#type').val(type);
        $('#description').val(description);
    });
</script>
