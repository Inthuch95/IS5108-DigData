	<?php
			
			if(isset($_SESSION['user'])and $_SESSION['user']!=''){
			print '<li class="dropdown">';
			print '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$_SESSION["user"];
			print '<span class="caret"></span></a>';
			print '<ul class="dropdown-menu">';
			print '<li><a href="PHP/LogOut.php">LogOut</a></li></ul></li>';
			  
			}
			else{
				print '<a href="login.php"> <span class="glyphicon glyphicon-log-in"></span> Login</a>';
			}
		?>