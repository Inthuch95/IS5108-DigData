<?php 
session_start();
include 'databaseConfig.php';
$searchStr = $_GET['searchStr'];

$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}

$searchStr = strtolower($searchStr);
$regex = "%".$searchStr."%";
print $regex;



$sql = "SELECT * FROM `is5108group-4__digdata`.Finds as find
      INNER JOIN `is5108group-4__digdata`.Context_Records cr on find.ContextID = cr.ContextID
      INNER JOIN `is5108group-4__digdata`.Site s on s.SiteCode = cr.SiteCode
      where LOWER(find.Name) LIKE ?
      or LOWER(find.Description) LIKE ?
      or LOWER(cr.Description) LIKE ?
      or LOWER(s.SiteName) LIKE ?
      or LOWER(s.Description) LIKE ?;";


$stmt = $connect->prepare($sql);  //prepares the query for action
$stmt->bind_param("sssss", $regex, $regex, $regex, $regex, $regex);  
echo "<br>".$sql."<br><br>";

/*where LOWER(find.Name) LIKE '%?%'
      or LOWER(find.Description) LIKE '%?%'
      or LOWER(cr.Description) LIKE '%?%'
      or LOWER(s.SiteName) LIKE '%?%'
      or LOWER(s.Description) LIKE '%?%';";*/

$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()){
	echo $row['FindID']." ";
	echo $row['Name']."<br>";
}


print '<table class="table table-hover table-bordered noBottomMargin">
	<tbody>
	<tr>
		<td width="100">
			<img src="https://png.icons8.com/metro/1600/batman-new.png" height="100"
				 width="100"
				 class="center-block" alt="Cinque Terre">
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
</table>';

?>