<!DOCTYPE html>
<?php
session_start();

?>
<html lang="en">
<head>
  <title>DigData - Add New Record</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src = "Script/Script.js"></script>
</head>
<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Dig Data</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="add_record.php">Add Record</a></li>
          <li><a href="search.php">Search</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="active">
		  <?php
		  include 'PHP/LoginButton.php';
		  ?>
		  </li>
        </ul>
      </div>
    </div>
  </nav>

  
<div class="container">
	<?php
		if($_SESSION['admin']==true&&isset($_SESSION['admin'])){
	?>
  <h2>Add new site</h2>
  <form class="form-horizontal" >
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-4">
	    <input class="form-control" id ="name" placeholder="Site name" name="name">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="description">Description:</label>
      <div class="col-sm-10">    
      <textarea class="form-control" placeholder="Site description" rows="5" id="description" name="description"></textarea>
       </div>
    </div>
    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button class="btn btn-default" onclick="confirmAddSite()">Submit</button>
		<div id="addResult"><?php
			if(isset($_SESSION["addResult"]) and $_SESSION["addResult"]!="" ){
				print $_SESSION["addResult"];
				$_SESSION["addResult"] = "";
			}
		?></div>
      </div>
	  
    </div>
    
  </form>
  	<?php
		}
		else{
			
			
	?>
		<h2>You are not allowed on this page</h2>
	<?php
		}	//INSERT INTO `Site` (`SiteCode`, `SiteName`, `Description`) VALUES (NULL, 'Olympus', 'This is where the gods live');
	
	
	?>

	
</div>

</body>
</html>
