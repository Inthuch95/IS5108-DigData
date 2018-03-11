<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
  <title>DigData - Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="bg">
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
			if(isset($_SESSION['user'])and $_SESSION['user']!=''){
				print '<a>';
				echo $_SESSION['user'];
				print '</a>';
			}
			else{
				print '<a href="login.php"> <span class="glyphicon glyphicon-log-in"></span> Login</a>';
			}
			?>
			</li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container" id="sign-in">
	
      <h3>Sign In</h3>
      <form class="form-horizontal" action="PHP/loginValidation.php" method="POST">
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Username:</label>
          <div class="col-sm-10">
            <input name="user" class="form-control" id="username" placeholder="Enter username">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Password:</label>
          <div class="col-sm-10">
            <input name="pass" type="password" class="form-control" id="pwd" placeholder="Enter password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
		  <?php 
		  if($_SESSION['loginerror']!=''){
			echo $_SESSION['loginerror']; 
			print "<br>";
			$_SESSION['loginerror']="";
		  }
			?>
            <button type="submit" class="btn btn-default">Login</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
