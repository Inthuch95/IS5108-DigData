	<?php
			
			if(isset($_SESSION['user'])and $_SESSION['user']!=''){
			print '<li class="dropdown">';
			print '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$_SESSION["user"]." ";
			print '<span class="caret"></span></a>';
			print '<ul class="dropdown-menu">';
			if($_SESSION['admin']==true&&isset($_SESSION['admin'])){
				  print '<li><a href="add_site.php">Add site</a></li>';
				  print '<li><a href="add_context.php">Add context</a></li>';
			  }
			 print "</ui></li>";
			print '<li><a href="PHP/LogOut.php">LogOut</a></li>';
			  
			}
			else{
				print '<a href="login.php"> <span class="glyphicon glyphicon-log-in"></span> Login</a>';
			}
		?>