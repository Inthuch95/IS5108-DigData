<!DOCTYPE html>
<?php
session_start();
//session_unset();
//$_SESSION['user'] = '';
?>
<html lang="en">
<head>
  <title>DigData</title>
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

  <div class="container">
    <h3>Welcome to Dig Data</h3>
    <p>In this template, bootstrap is used to make the website responsive.</p>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr>
                    <td width="100">
                        <img src="https://png.icons8.com/metro/1600/batman-new.png" height="100" width="100"
                             class="center-block" alt="Cinque Terre">
                    </td>
                    <td>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td><strong>ID: </strong>0000</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Location: </strong>.........<strong>Founder: </strong>.........<strong>Date: </strong>xx/xx/xxxx
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Description: </strong>Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit. Integer in nunc mattis, consectetur nunc at, blandit metus. Cras faucibus
                                    facilisis malesuada. Donec in tellus vitae tortor convallis pulvinar blandit id
                                    ligula. Fusce sodales maximus libero sed viverra. Aenean blandit aliquam tortor a
                                    finibus. Ut rutrum neque non interdum aliquam. Suspendisse erat eros, rhoncus eu
                                    erat et, luctus faucibus tellus. Fusce quis fermentum sem. Proin sagittis vel justo
                                    sed auctor. Curabitur ultrices magna ut erat condimentum, quis pulvinar nibh auctor.
                                </td>
                            </tr>
                            <tr>
                                <td>Lorem ipsum donec id elit non mi porta gravida at eget metus.</td>
                            </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-default pull-right" type="submit">Detail</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
