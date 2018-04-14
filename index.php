<?php
session_start();

$username = "is5108group-4";
$password = "b9iVc.9gS8c7NJ";
$host = "is5108group-4.host.cs.st-andrews.ac.uk";
$db = "is5108group-4__digdata";
$tb = "Finds";
//session_unset();
//$_SESSION['user'] = '';
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
                <li class="active"><a href="index.php">Home</a></li>
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


<?php
$connect = mysqli_connect($host, $username, $password);
if (!$connect) {
    echo "Can't connect to SQLdatabase ";
    exit();
} else {
    mysqli_select_db($connect, $db) or die("Can't select Database");
    //SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM Finds INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode ORDER BY `Date` DESC
    $sql = "SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM Finds 
	INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID 
	INNER JOIN Site s ON s.SiteCode = cr.SiteCode 
	INNER JOIN Users ON Finds.UserID = Users.UserID 
	ORDER BY `Date` DESC ";
	
	
	
    $find = mysqli_query($connect, $sql);
    $found = mysqli_num_rows($find);
    //echo $sql;
    //echo $found;
	
}

?>
<div class="container" style="margin-top:50px">
    <h3>Welcome to Dig Data</h3>
    <?php
    $i = 0;
    while ($row = mysqli_fetch_array($find, MYSQLI_ASSOC) and $i < 5) {
        $i = $i + 1;

        //printf ("%s (%s) %s %s %s %s\n",$row["FindID"],$row["UserID"],$row["ContextID"],$row["FDESC"],$row["Type"],$row["Date"]);?>
        <form action="view_record.php" method="get">
            <input type="hidden" name="id" value="<?php printf("%s", $row["FindID"]) ?>"/>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <td width="100">
							<?php
							$findID = $row["FindID"];
							$sql1 = "SELECT * FROM `PhotoSet-Find Links` as link INNER JOIN Photos on link.PhotoSetID = Photos.PhotoSetID WHERE FindID = $findID";
							$findPics = mysqli_query($connect, $sql1);
							$numrow = mysqli_num_rows($findPics);
							if($numrow>0){
								$pic=mysqli_fetch_array($findPics,MYSQLI_ASSOC);
								print '<img src="'.$pic["Directory Path"].'" height="100" width="100"
								class="center-block" alt="Cinque Terre">';
							}
							else{
								print '<img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100"
                                     class="center-block" alt="Cinque Terre">';
								
							}
							?>
                                
                            </td>
                            <td>
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td><strong>ID: </strong><?php printf("%s", $row["FindID"]) ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Location: </strong><?php printf("%s", $row["SiteName"]) ?> <strong>Finder: </strong><?php printf("%s", $row["First Name"]) ?>
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
                                <div class="row">
                                    <div class="col-sm-2">
                                        <button class="btn btn-warning" type="submit" formaction="edit_record.php"><i
                                                    class="fas fa-edit"></i>&nbsp;Edit
                                        </button>
                                    </div>
                                    <div class="col-sm-2 col-sm-offset-3 text-center">
                                        <button class="btn btn-info" type="submit"><i class="fas fa-info-circle fa-lg"></i>&nbsp;Details
                                        </button>
                                    </div>
                                    <div class="col-sm-2 col-sm-offset-3">
                                        <button class="btn btn-danger pull-right" type="submit" formaction="PHP/deleteRecord.php"><i
                                                    class="fas fa-trash-alt"></i>&nbsp;Delete</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    <?php } ?>
</div>
</body>
</html>
