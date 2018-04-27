<?php
session_start();
$findID = $_GET["id"];

include 'PHP/databaseConfig.php';

$tb = "Finds";

$connect = mysqli_connect($host, $username, $password);
if (!$connect) {
    echo "Can't connect to SQLdatabase ";
    exit();
} else {
    mysqli_select_db($connect, $db) or die("Can't select Database");
    $find = mysqli_query($connect, "SELECT *,s.Description AS 'STDESC',Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM $tb 
	INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID 
	INNER JOIN Site s ON s.SiteCode = cr.SiteCode 
	WHERE $tb.FindID = $findID");
    $row = mysqli_fetch_array($find, MYSQLI_ASSOC);
   
    $findId = $row["FindID"];
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
    <h2>Artifact: <?php printf("%s", $row["Name"]) ?></h2>
    <div class="row">
        <div class="col-md-12">
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
                                    <?php
									$sql = "SELECT * FROM Users WHERE UserID = ".$row['UserID'];
									$find2 = $connect->query($sql);
									$row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC);
									?>
                                    <strong>Finder: </strong><?php printf("%s", $row2["First Name"]); ?>
                                    <strong>Date: </strong><?php printf("%s", $row["Date"]) ?>
                                </td>
                            </tr>
							<tr>
                                <td><strong>Type: </strong><?php printf("%s", $row["Type"]) ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Description: </strong><?php printf("%s", $row["FDESC"]) ?>
                                </td>
                            </tr>
                            <?php
                            if($row["ModifiedBy"]===NULL){}
                            else
                            {?>
                              <tr>
                                  <td><strong>Last modified: </strong><?php printf("%s", $row["ModifiedBy"]." ".$row["LastModified"]); ?></td>
                              </tr>
                            <?php
                            }?>
                         
                          </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="row">
              <?php
              $sql = "SELECT * FROM `PhotoSet-Find Links` as link
              INNER JOIN PhotoSets ps on link.PhotoSetID = ps.PhotoSetID
              INNER JOIN Photos ph on ph.PhotoSetID = ps.PhotoSetID
              where FindID = $findId;";

              $find2 = mysqli_query($connect, $sql);
              while ($row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC)){
                print '  <div class="col-sm-4 col-md-2">
                      <div class="thumbnail">
                          <a href="#" class="pop">
                              <img src="'.$row2['Directory Path'].'" width="200">
                          </a>
                      </div>
                  </div>';

              }


              ?>


            </div>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>
                        <table class="table table-bordered noBottomMargin">
                            <tbody>
                            <tr hidden>
                                <td><strong class="text-danger">CONTEXT ID: </strong><?php printf("%s", $row["ContextID"]) ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Location: </strong><?php printf("%s", $row["SiteName"]) ?>
                                </td>
                            </tr>
							<tr>
                                <td>
                                    <strong>Site description: </strong><?php printf("%s", $row["STDESC"]) ?>
                                </td>
                            </tr>
							<?php if($row["Interpretation"]!="")
							{
								?>
                            <tr>
                                <td><strong>Interpretation: </strong><?php printf("%s", $row["Interpretation"]) ?>
                                </td>
                            </tr><?php } ?>
                            <tr>
                                <td><strong>Context description: </strong><?php printf("%s", $row["CRDESC"]) ?>
                                </td>
                            </tr>
                            
                            <tr>
							
                                <td>
                                    <div class="panel-group" id="accordion">
									<?php 
									$sql = "SELECT * FROM `PhotoSet-Context Links` as link
											INNER JOIN PhotoSets ps on link.PhotoSetID = ps.PhotoSetID
											INNER JOIN Photos ph on ps.PhotoSetID = ph.PhotoSetID 
											WHERE ContextID =". $row['ContextID']." and ps.Direction = 'East';";
									
									$find2 = $connect->query($sql);
									if($find2-> num_rows >0){
									?>
                                    <div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
													East</a>
											</h4>
										</div>
										<div id="collapse1" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="row">
													<div class="col-md-12">
													<?php 
													$findDesc = $connect->query($sql);
													$row2 = mysqli_fetch_array($findDesc, MYSQLI_ASSOC);
													echo $row2['Description'];
													?>
													</div>
												</div>
												<div class="row">
												<?php 
												while($row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC)){
												?>
													<div class="col-sm-4 col-md-2">
														<div class="thumbnail">
															<a href="#" class="pop">
																<img src="<?php print $row2['Directory Path']; ?>" height="200" width="200">
															</a>
														</div>
													</div>
												<?php	
												}
												?>
													
												
												</div>
											</div>
										</div>
									</div>
									<?php
											}
									?>
										
                                        
									<?php 
									$sql = "SELECT * FROM `PhotoSet-Context Links` as link
											INNER JOIN PhotoSets ps on link.PhotoSetID = ps.PhotoSetID
											INNER JOIN Photos ph on ps.PhotoSetID = ph.PhotoSetID 
											WHERE ContextID =". $row['ContextID']." and ps.Direction = 'West';";
									
									$find2 = $connect->query($sql);
									if($find2-> num_rows >0){
									?>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
													West</a>
											</h4>
										</div>
										<div id="collapse2" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="row">
													<div class="col-md-12">
													<?php 
													$findDesc = $connect->query($sql);
													$row2 = mysqli_fetch_array($findDesc, MYSQLI_ASSOC);
													echo $row2['Description'];
													?>
													</div>
												</div>
												<div class="row">
												<?php 
												while($row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC)){
												?>
													<div class="col-sm-6 col-md-2">
														<div class="thumbnail">
															<a href="#" class="pop">
																<img src="<?php print $row2['Directory Path']; ?>" height="200" width="200">
															</a>
														</div>
													</div>
												<?php	
												}
												?>
													
												
												</div>
											</div>
										</div>
									 </div>
									<?php
									}
									?>
									<?php 
									$sql = "SELECT * FROM `PhotoSet-Context Links` as link
											INNER JOIN PhotoSets ps on link.PhotoSetID = ps.PhotoSetID
											INNER JOIN Photos ph on ps.PhotoSetID = ph.PhotoSetID 
											WHERE ContextID =". $row['ContextID']." and ps.Direction = 'North';";
									
									$find2 = $connect->query($sql);
									if($find2-> num_rows >0){
									?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                                        North</a>
                                                </h4>
                                            </div>
                                            <div id="collapse3" class="panel-collapse collapse">
                                                <div class="panel-body">
												<div class="row">
													<div class="col-md-12">
													<?php 
													$findDesc = $connect->query($sql);
													$row2 = mysqli_fetch_array($findDesc, MYSQLI_ASSOC);
													echo $row2['Description'];
													?>
													</div>
												</div>
												<div class="row">
												<?php 
												while($row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC)){
												?>
													<div class="col-md-6 col-md-2">
														<div class="thumbnail">
															<a href="#" class="pop">
																<img src="<?php print $row2['Directory Path']; ?>" height="200" width="200">
															</a>
														</div>
													</div>
												<?php	
												}
												?>
													
												
												</div>
											</div>
                                            </div>
                                        </div>
										
									<?php
									}
									?>
									<?php 
									$sql = "SELECT * FROM `PhotoSet-Context Links` as link
											INNER JOIN PhotoSets ps on link.PhotoSetID = ps.PhotoSetID
											INNER JOIN Photos ph on ps.PhotoSetID = ph.PhotoSetID 
											WHERE ContextID =". $row['ContextID']." and ps.Direction = 'South';";
									
									$find2 = $connect->query($sql);
									if($find2-> num_rows >0){
									?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                                        South</a>
                                                </h4>
                                            </div>
                                            <div id="collapse4" class="panel-collapse collapse">
                                                <div class="panel-body">
												<div class="row">
													<div class="col-md-12">
													<?php 
													$findDesc = $connect->query($sql);
													$row2 = mysqli_fetch_array($findDesc, MYSQLI_ASSOC);
													echo $row2['Description'];
													?>
													</div>
												</div>
												<div class="row">
												<?php 
												while($row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC)){
												?>
													<div class="col-md-6 col-md-2">
														<div class="thumbnail">
															<a href="#" class="pop">
																<img src="<?php print $row2['Directory Path']; ?>" height="200" width="200">
															</a>
														</div>
													</div>
												<?php	
												}
												?>
													
												
												</div>
											</div>
                                            </div>
                                        </div>
										
									<?php
									}
									?>
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
