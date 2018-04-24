<?php
session_start();
$_SESSION["currentPage"] = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DigData - Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"
            integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ"
            crossorigin="anonymous"></script>
	<script>
	function search(){
		var xhttp;
		var searchStr = $("#searchStr").val();
		
		
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();

		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}


		xmlhttp.onreadystatechange = function() {

			if (this.readyState == 4 && this.status == 200) {
				$("#searchRes").html(this.responseText);
			}
		};

		xmlhttp.open("GET", "PHP/getSearchResult.php?searchStr="+searchStr, true);
		xmlhttp.send();
		

	}
	
	function onload(){
		var xhttp;
		
		
		<?php if(isset($_SESSION["searchStr"])){
		print 'var searchStr = "'.$_SESSION["searchStr"].'"';
		
		
		?>
			
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();

		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}


		xmlhttp.onreadystatechange = function() {

			if (this.readyState == 4 && this.status == 200) {
				$("#searchRes").html(this.responseText);
			}
		};

		xmlhttp.open("GET", "PHP/getSearchResult.php?searchStr="+searchStr, true);
		xmlhttp.send();
		<?php
		}
		?>
		

	}
	
	</script>
</head>
<body onload=onload()>


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
                <li class="active"><a href="search.php">Search</a></li>
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
    <h3>Search</h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 class="text-center">Search Filter&nbsp;<i class="fas fa-filter"></i></h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="#">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="id">ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="id" placeholder="Enter ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="location">Location</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="location">
                                    <option>John Honey Building</option>
                                    <option>Thanon - Thai Restaurant</option>
                                    <option>The Tailend Restaurant and Fish Bar</option>
                                    <option>Little Italy</option>
                                    <option>Tesco</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="finder">Finder</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="finder">
                                    <option>Nattasan</option>
                                    <option>Inthuch</option>
                                    <option>Turk</option>
                                    <option>Anna</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="from">From</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="date" id="from">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="from-butt">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="to">To</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="date" id="to">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="to-butt">
                                            <i class="far fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group noBottomMargin">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary pull-right">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div id="searchBody" class="panel-body">
                    <div class="row">
                        <div class="col-sm-5">
                            
                                <div class="input-group">
                                    <input type="text" id="searchStr" name="searchStr" class="form-control" placeholder="Search"
									<?php
									if(isset($_SESSION["searchStr"])){
										print 'value="'.$_SESSION["searchStr"].'"';
									}
									?>
									>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" onclick="search()" type="submit">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                           
                        </div>
                        <div class="col-sm-4">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Found:</label>
                                    <div class="col-sm-9">
                                        <p class="form-control-static">xxxx records</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-default pull-right">
                                Sort&nbsp;<i class="fas fa-sort-up"></i>
                            </button>
                        </div>
                    </div>
					<div id="searchRes">
                    <table class="table table-hover table-bordered noBottomMargin">
                        <tbody>
                        <tr>
                            <td width="100">
                                <img src="" height="100"
                                     width="100"
                                     class="center-block" alt="Picture">
                            </td>
                            <td>
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td><strong>ID: </strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Location: </strong>
                                            <strong>Founder: </strong>
                                            <strong>Date: </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Description: </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lorem ipsum donec id elit non mi porta gravida at eget
                                            metus.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-info pull-right" type="submit"><i class="fas fa-info-circle fa-lg"></i>&nbsp;Details</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<script type="text/javascript">
    $(function () {
        $('#from').datepicker({
            onSelect: function (selectedDate) {
                var min = $('#from').datepicker('getDate');
                min.setDate(min.getDate() + 1);
                $('#to').datepicker("option", "minDate", min).datepicker("setDate", min);
            }
        });
        $('#to').datepicker({
            onSelect: function (selectedDate) {
                var max = $('#to').datepicker('getDate');
                max.setDate(max.getDate() - 1);
                $('#from').datepicker("option", "maxDate", max);
            }
        });
        $("#from-butt").click(function () {
            $('#from').datepicker("show");
        });
        $("#to-butt").click(function () {
            $('#to').datepicker("show");
        });
    });
</script>
