<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<head>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://localhost:63342/www3/index.php">Magic Lunch Matching</a>
            </div>

        </div>
    </nav>
</head>

<body class="jumbotron">
<form method="get">
    <dl>
        </br>
        <dt class="lead"> Please Enter User ID: </dt>

        <dd><input class="lead" type="text" value="" name="user_id" />
            <?php if((isset($_GET['user_id'])) && ($_GET['user_id'] == "")){
                echo " Please write a correct user id.";
            }
            ?>
        </dd>
        </br>
        <dt>
            <input class="btn btn-primary btn-lg" type="submit" value="Start" />
        </dt>
    </dl>
</form>

<?php header('Content-Type: text/html; charset=utf-8');
$servername = "localhost:8889";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password,'Lunchback');
$conn->set_charset("utf8");
//printf($conn->character_set_name());

$sql_1 = "SELECT masterId, concat(lunchback_user_profiles.first_name,' ',lunchback_user_profiles.last_name) as masterName, lunchback_user_profiles.headline, 
lunchback_user_profiles.base_city as masterLocation FROM (

SELECT masterId,candidateId FROM (
SELECT DISTINCT t1.user_id as masterId,
                concat(p1.first_name,' ',p1.last_name) as masterName,
                p1.headline,p2.id as candidateId

FROM lunchback_user_tags t1 JOIN lunchback_user_tags t2,
  lunchback_user_profiles p1 JOIN lunchback_user_profiles p2
WHERE t2.user_id = ".$_GET['user_id']."
      AND t1.user_id != t2.user_id
      AND t1.tag_type = 'offering'
      AND t2.tag_type = 'searching'
      AND t1.tag = t2.tag
      AND p1.id = t1.user_id
      AND p2.id = t2.user_id
      AND t2.tag = t1.tag
      AND p1.base_city = p2.base_city
      AND p1.removed = 0
      AND p2.removed = 0
      AND t1.removed = 0
      AND t2.removed = 0
UNION
SELECt DISTINCT h1.target_id as masterId ,
                concat(p.first_name,' ',p.last_name) as masterName,
                p.headline,h1.user_id as candidateId
FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p
WHERE h1.user_id = ".$_GET['user_id']."
      AND h2.user_id = h1.target_id
      AND h2.target_id = h1.user_id
      AND p.id = h1.target_id) AS FOO
              )AS FAK INNER JOIN
                  lunchback_user_interested_user ON masterId = lunchback_user_interested_user.user_id,lunchback_user_profiles
WHERE candidateId = target_id
AND masterId = lunchback_user_profiles.id
UNION
SELECt DISTINCT h1.target_id as masterId ,
                concat(p.first_name,' ',p.last_name) as masterName,
                p.headline, p.base_city as masterLocation 
FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p
WHERE h1.user_id = ".$_GET['user_id']."
      AND h2.user_id = h1.target_id
      AND h2.target_id = h1.user_id
      AND p.id = h1.target_id
      AND h1.user_id != h1.target_id
";

$sql_2 = "SELECT CONCAT(first_name,' ',last_name) as clename  FROM Lunchback.lunchback_user_profiles
WHERE id = ".$_GET['user_id'];


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query($sql_1);
$result2 = $conn->query($sql_2);


/*
if (!$result) {
    echo 'Could not run query: '.printf($result->num_rows);
    exit;}
*/

if($result2->num_rows != 0) {
    $rows= $result2->fetch_assoc();
    $Clname = $rows["clename"];
    echo "<p class=\"lead\"> Hey $Clname! </p>";}

if($result->num_rows != 0) {
    $rows= $result->fetch_assoc();
    $Base = $rows["masterLocation"];
    echo "  
            <p class=\"lead\">  Here are some cool people who work in $Base that we would recommend you to have lunch with: </p> 
            <table class=\"table table-striped table-hover \" style=\"width:100%\">
            <tr class=\"info\">
            <th>Name</th>
            <th>Headline</th>
            </tr>";
    while ($rows= $result->fetch_assoc()){
        $Mname = $rows["masterName"];
        $Hline = $rows["headline"];

        echo "
            <tr>
            <td>$Mname</td>
            <td>$Hline</td>
            </tr>
            ";

    }
}else {
    $rows= $result2->fetch_assoc();
    $Clname = $rows["clename"];
    echo "<p class=\"lead\"></p>";
    echo "<p class=\"lead\">Unfortunately we can't find a match for you right now, but please keep in touch :D </p>";
    //echo $_GET['user_id'];

}



?>

</body>
</html>