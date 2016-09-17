<?php
$servername = "localhost:8889";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password,'Lunchback');
$sql = "SELECT DISTINCT 
  table1.user_id as masterId,
  concat(p1.first_name,' ',p1.last_name) as masterName,
  p1.headline,
  table2.tag as searching,
  concat(p2.first_name,' ',p2.last_name) as candidateName,
  p2.base_city as cadidateLocation


FROM lunchback_user_tags table1 JOIN lunchback_user_tags table2
  JOIN lunchback_user_profiles p1 JOIN lunchback_user_profiles p2

WHERE table2.user_id = 1
      AND table1.user_id != table2.user_id
      AND table1.tag_type = 'offering'
      AND table2.tag_type = 'searching'
      AND table1.tag = table2.tag
      AND p1.id = table1.user_id
      AND p2.id = table2.user_id
      AND table2.tag = table1.tag
      AND p1.base_city = p2.base_city
      AND p1.removed = 0
      AND p2.removed = 0
      AND table1.removed = 0
      AND table2.removed = 0
ORDER BY searching";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query($sql);

//if (!$result) {
//echo 'Could not run query: '.printf($result->num_rows);
//    exit;}


if($result->num_rows != 0) {
    while ($rows= $result->fetch_assoc()){
        $Mname = $rows["masterName"];
        echo "<p> Name: $Mname </p>";

    }
}else {
    echo "Unfortunately we can't find a match for you right now  \n";

}



?>
