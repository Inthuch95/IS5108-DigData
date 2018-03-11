<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
  <title>DigData - Search</title>
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
          <li><a href="add_record.php">Add Record</a></li>
          <li class="active"><a href="search.php">Search</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><?php
			if(isset($_SESSION['user'])and $_SESSION['user']!=''){
				print '<a>';
				echo $_SESSION['user'];
				print '</a>';
			}
			else{
				print '<a href="login.php"> <span class="glyphicon glyphicon-log-in"></span> Login</a>';
			}
			?></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h3>Search</h3>
  </div>

</body>
</html>
