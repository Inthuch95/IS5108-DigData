<!DOCTYPE html>
<?php
session_start();
$_SESSION["currentPage"] = '';
$username="is5108group-4";
$password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
$db="is5108group-4__digdata";
$tb = "Site";

$connect= mysqli_connect($host,$username,$password);
	if (!$connect )
		{
			echo "Can't connect to SQLdatabase ";
			exit();
		}
	else
	{
		mysqli_select_db($connect,$db) or die("Can't select Database");
		//SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM Finds INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode ORDER BY `Date` DESC
			$find = mysqli_query($connect,"SELECT * FROM $tb");
			$found = mysqli_num_rows($find);
		//echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
		//echo $found;
	}

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
  
  <script>
	function showContext(site) {
		
	var xhttp; 
	if (site == "") {
		document.getElementById("context").innerHTML = "<option> Select site first</option>";
		return;
	}else { 
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
			
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		
		xmlhttp.onreadystatechange = function() {
			
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("context").innerHTML = this.responseText;
				document.getElementById("contextDesc").style.display = "none";
			}
		};
		
	xmlhttp.open("GET", "PHP/getContextBySite.php?q="+site, true);
	xmlhttp.send();
	}
}
  
  
  </script>
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
      <div class="col-sm-4">
        <select class="form-control" id="location" placeholder="Select location" name="site" onchange="showContext(this.value)">
		<option value="">Select a site</option>
		<?php
		 while ($row=mysqli_fetch_array($find,MYSQLI_ASSOC)) {
			 print '<option value="'.$row["SiteCode"].'">'.$row["SiteCode"]." - ".$row["SiteName"].'</option>';
		 }
		?>
          
        </select>
        
      </div>
    </div>
	 <div class="form-group">
      <label class="control-label col-sm-2" for="finder">Finder:</label>
      <div class="col-sm-4">
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
      <div class="col-sm-4">          
            <input class="form-control" type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
      </div>
      
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="type">Type:</label>
      <div class="col-sm-4">
        <select class="form-control" id="type" name="type">
          <option value="Metal">Metal</option>
          <option value="Wood">Wood</option>
          <option value="Rock">Rock</option>
        </select>
        
      </div>
    </div>
	
	<?php
		mysqli_select_db($connect,$db) or die("Can't select Database");
		//SELECT *,Finds.Description AS 'FDESC',cr.Description AS 'CRDESC' FROM Finds INNER JOIN Context_Records cr ON Finds.ContextID = cr.ContextID INNER JOIN Site s ON s.SiteCode = cr.SiteCode ORDER BY `Date` DESC
		$find = mysqli_query($connect,"SELECT * FROM Context_Records");
		$found = mysqli_num_rows($find);
	?>
	 <div class="form-group">
      <label class="control-label col-sm-2" for="context">Context:</label>
      <div class="col-sm-4">
        <select class="form-control" id="context" name="context">
		<option value = "">Select site first</option>
        
        </select>
        <p id="contextDesc" hidden>sfghsdfgh</p>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="trench">Area:</label>
      <div class="col-sm-4">
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
  	<?php
					mysqli_close($connect);
					?>
</div>

</body>
</html>
