	<?php
	session_start();
	$LOGusername=$_POST["user"];
	$LOGpassword=$_POST["pass"];
	$host="is5108group-4.host.cs.st-andrews.ac.uk";
	//$host="localhost";
	$username="is5108group-4";
	$password="b9iVc.9gS8c7NJ";
	$valid=false;
	$db="is5108group-4__digdata";
	$tb = "Users";
	
	$connect= mysqli_connect($host,$username,$password);
	if (!$connect )
		{
			echo "Can't connect to SQLdatabase ";
			exit();
		}
	else
	{
		mysqli_select_db($connect,$db) or die("Can't select Database");
			$find = mysqli_query($connect,"SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'");
			$found = mysqli_num_rows($find);
		//echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword'";
		//echo $found;
	}
		
	if ($found) 
	{
			$valid=true;
			$_SESSION['loginerror']="Login successful";
				$admin=mysqli_query($connect,"SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword' AND Position='Administrator'");
				$ad=mysqli_num_rows($admin);
				//echo "SELECT * FROM $tb WHERE Username='$LOGusername' AND Password='$LOGpassword' AND Position='Administration'";
				if($ad)$_SESSION['admin']=true;
				
				
	}else
	{
		$_SESSION['loginerror']="Wrong Username or Password";
	}
	
	?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>
<?php 	// assume correct user pass word
							
						if($valid==true){ //general user
							$_SESSION['loginpass']=true;
							$_SESSION['user']=$LOGusername;
							
							$_SESSION['loginerror']="";
							header("Location:../index.php");
					
						}else{
							
							header("Location:../login.php"); /* Redirect browser */
						exit();
							?>
							
							<?php 
							echo $_SESSION['loginerror']; 
							?>
							</font>
							<?php
							}
						
						if($_SESSION['loginerror']=="Wrong Username or Password")$_SESSION['loginerror']="";?>
						
						
						<?php
					mysqli_close($connect);
					?>
</html>