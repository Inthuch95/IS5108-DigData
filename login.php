<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DigData - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"
            integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="bg">
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
                    <li class="active"><?php
                        include 'PHP/LoginButton.php';
                        ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top:50px" id="sign-in">
        <h3>Sign In</h3>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default noBorder noBottomMargin">
                    <div class="panel-body">
                        <form class="form-horizontal" data-toggle="validator" role="form" action="PHP/loginValidation.php" method="POST">
                            <div class="form-group has-feedback">
                                <label class="control-label col-sm-1 col-sm-offset-1" for="email"><i class="fas fa-user"></i></label>
                                <div class="col-sm-10">
                                    <input name="user" class="form-control" id="username" placeholder="Enter Username" data-error="Please fill in this field" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label col-sm-1 col-sm-offset-1" for="pwd"><i class="fas fa-key"></i></label>
                                <div class="col-sm-10">
                                    <input name="pass" type="password" class="form-control" id="pwd" placeholder="Enter Password" data-error="Please fill in this field" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php
                                    if (isset($_SESSION['loginerror']) and $_SESSION['loginerror'] != '') {
                                        print '<div class="alert alert-danger">' . $_SESSION['loginerror'];
                                        $_SESSION['loginerror'] = "";
                                        print '</div>';
                                    }
                                    ?>
                                    <button type="submit" class="btn btn-success pull-right"><i class="fas fa-sign-in-alt fa-lg"></i>&nbsp;Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
