<!DOCTYPE html>
<?php
session_start();
$_SESSION["currentPage"] = '';
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
          <li class="active"><a href="add_record.php">Add Record</a></li>
          <li><a href="search.php">Search</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><?php
		  include 'PHP/LoginButton.php';
			?></li>
        </ul>
      </div>
    </div>
  </nav>

  
<div class="container">
  <h2>Add record</h2>
  <form class="form-horizontal" action="/action_page.php">
    <div class="form-group">
      <label class="control-label col-sm-2" for="location">Location:</label>
      <div class="col-sm-3">
        <select class="form-control" id="location" placeholder="Select location" name="site">
          <option value="Site 1">Site 1</option>
          <option value="Site 2">Site 2</option>
          <option value="Site 3">Site 3</option>
        </select>
        
      </div>
    </div>
	 <div class="form-group">
      <label class="control-label col-sm-2" for="finder">Finder:</label>
      <div class="col-sm-3">
	  <?php
		
		if(isset($_SESSION['user'])and $_SESSION['user']!=''){
			print '<input class="form-control" type="" name="finder" value="'.$_SESSION["user"].'" readonly>';
		}
		else{
			$_SESSION['loginerror'] = "You have to login first";
			$_SESSION["currentPage"] = basename($_SERVER['PHP_SELF']);
			
			header("Location:login.php");
		}
		?>
		
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Date:</label>
      <div class="col-sm-3">          
            <input class="form-control" type="date" name="date">
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
      <label class="control-label col-sm-2" for="context">Context:</label>
      <div class="col-sm-3">
        <select class="form-control" id="context" name="context">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
        
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="trench">Area:</label>
      <div class="col-sm-3">
        <select class="form-control" id="trench" name="trench">
          <option value="1">trench 1</option>
          <option value="2">trench 2</option>
          <option value="3">trench 3</option>
          <option value="4">trench 4</option>
          <option value="5">trench 5</option>
        </select>
        
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="description">Description:</label>
      <div class="col-sm-10">    
      <textarea class="form-control" rows="5" id="description"></textarea>
       </div>
    </div>
    
    
    
    
    
    
    
    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
    
  </form>
</div>

</body>
</html>
