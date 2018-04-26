<?php
session_start();
include 'databaseConfig.php';
$searchStr = $_GET['searchStr'];
$site = $_GET["site"];
$finder = intval($_GET["finder"]);
$from = $_GET["from"];
$to = $_GET["to"];
$_SESSION["searchStr"] =  $searchStr;

$connect = new mysqli($host, $username, $password, $db);
// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}

$searchStr = strtolower($searchStr);
$regex = "%".$searchStr."%";

$sql = "SELECT *,find.Description AS 'FDESC' FROM Finds AS find
      INNER JOIN `is5108group-4__digdata`.Context_Records cr ON find.ContextID = cr.ContextID
      INNER JOIN `is5108group-4__digdata`.Site s ON s.SiteCode = cr.SiteCode
	  INNER JOIN Users u ON u.UserID = find.UserID
      WHERE (LOWER(find.Name) LIKE ?
      OR LOWER(find.Description) LIKE ?
      OR LOWER(cr.Description) LIKE ?
      OR LOWER(s.SiteName) LIKE ?
      OR LOWER(s.Description) LIKE ?)";
if ($site != "all") {
  $sql = $sql." AND cr.SiteCode = $site";
}
if ($finder != "all") {
  $sql = $sql." AND find.UserID = $finder";
}
if ($from != "") {
  $sql = $sql." AND find.Date >= '$from'";
}
if ($to != "") {
  $sql = $sql." AND find.Date <= '$to'";
}
$sql = $sql.";";
$stmt = $connect->prepare($sql);  //prepares the query for action
$stmt->bind_param("sssss", $regex, $regex, $regex, $regex, $regex);
$stmt->execute();
$res = $stmt->get_result();
$row_count = $res -> num_rows;

if ($row_count > 0) {
  while ($row = $res->fetch_assoc()){

  $sql = "SELECT * FROM `PhotoSet-Find Links` as link
                INNER JOIN PhotoSets ps on link.PhotoSetID = ps.PhotoSetID
                INNER JOIN Photos ph on ph.PhotoSetID = ps.PhotoSetID
                where FindID = ".$row['FindID'].";";

  $find2 = mysqli_query($connect, $sql);
  $found = mysqli_num_rows($find2);


  print '<table class="table table-hover table-bordered noBottomMargin">
    <tbody>
    <tr>
      <td width="100">';

  if ($found>0){
    $row2 = mysqli_fetch_array($find2, MYSQLI_ASSOC);

  //$row2 = $res2->fetch_assoc();
  print '<img src="'.$row2["Directory Path"].'" height="100"
           width="100"
        class="center-block" alt="Cinque Terre">';
  }else{

  print 	'<img src="https://png.icons8.com/metro/1600/batman-new.png" height="100"
           width="100"
        class="center-block" alt="Picture">';
  }

  print ' </td>
      <td>
        <table class="table table-bordered">
          <tbody>
          <tr>
            <td><strong>'.$row["Name"].'</strong></td>
          </tr>
          <tr>
            <td>
              <strong>Location: </strong>'.$row["SiteName"].'

            </td>
          </tr>
          <tr>
            <td>
              <strong>Founder: </strong>'.$row["First Name"].'
              <strong>Date: </strong>'.$row["Date"].'
            </td>
          </tr>
          <tr>
            <td><strong>Description: </strong>'.$row["FDESC"].'
            </td>
          </tr>
          </tbody>
        </table>
        <form action="edit_record.php" method="get">
          <input type="hidden" name="id" value="'.$row["FindID"].'"/>
          <button class="btn btn-warning pull-left" type="submit"><i
                class="fas fa-edit"></i>&nbsp;Edit
          </button>
              </form>
        <form action="view_record.php" method="get">
            <input type="hidden" name="id" value="'.$row["FindID"].'"/>
            <button class="btn btn-info pull-right" type="submit"><i class="fas fa-info-circle fa-lg"></i>&nbsp;Details
            </button>
              </form>
              <form action="PHP/deleteRecord.php" method="get" onsubmit="'."return confirm('Are you sure you want to delete this record?');".'">
                  <input type="hidden" name="id" value="' . $row["FindID"] . '"/>
                  <button class="btn btn-danger" type="submit"><i
                              class="fas fa-trash-alt"></i>&nbsp;Delete</button>
              </form>

      </td>
    </tr>
    </tbody>
  </table>';

    //echo $row['FindID']." ";
    //echo $row['Name']."<br>";
  }
} else {
  echo "no result";
}
 ?>
