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
    <script src="Script/Script.js"></script>
	<!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"
            integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ"
            crossorigin="anonymous"></script>
    <script>
	var numPic = 0;
    function moreImage(id){
		butID = "moreImg" + numPic;
		numPic++;
		console.log("more image box"+id);
		$("#"+id).append('\
		<div class="row">\
		<div class="col-sm-4">\
			<input class="form-control" type="file" name="'+id+'[]" >\
		</div>\
		<div class="col-sm-1">\
			<input class="btn" type=button id='+butID+' onclick=removeImg("'+butID+'") value ="X">\
		</div>\
		</div>\
		') ;
    }

	function removeImg(id){
		console.log("remove"+id);
		$("#"+id).parent().parent().remove();

	}

	function showUploadBox(thisID,showid){

		if($("#"+thisID).is(":checked")){
			$("#"+showid).show();
		}
		else{
			$("#"+showid).hide();
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
                        <form class="form-horizontal" action="PHP/insertPhotoSet.php" method='post' enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="location">Location:</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="location" placeholder="Select location" name="site"
                                            onchange="showTrench(this.value)">
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
                            <label class="control-label col-sm-2" for="date">Date:</label>
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
                                <label class="control-label col-sm-2" for="direction">Direction:</label>
                                <div class="col-sm-3">
									<select class="form-control" id="direction" name="direction"
											onchange="">
										<option value="East">East</option>
										<option value="West">West</option>
										<option value="North">North</option>
										<option value="South">South</option>
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

								<label class="control-label col-sm-2" for="fileToUpload">Select images:</label>
								<div class="col-sm-10" id="imgs">
									<div class="row">
										<div class="col-sm-4">
											<input class="form-control" type="file" name="imgs[]">
										</div>


										<div class="col-sm-1">
											<input class="btn" type=button onclick=moreImage("imgs") value ="Add">
										</div>
									</div>


								</div>
							</div>



                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success pull-right">Submit</button>
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
