<?php
session_start();

if (isset($_POST['submitclaims'])) {
  $claimedSet = "";
  $arr = array();
  foreach ($_POST as $key => $value) {
    if ($value == 'on') {
      $a = str_split($key);
      $arr[$a[0]] = $arr[$a[0]].$a[1];
    }
  }
  foreach ($arr as $key => $value) {
    $claimedSet = $claimedSet.$key.$value;
  }

  //Connect to db
  $dbconn = pg_connect("host=localhost port=5432 dbname=postgres");
  if (!$dbconn) {
    echo "Error: Could not connect to database. \n";
    exit;
  }
  $query = "INSERT INTO Claims VALUES ('".$_SESSION['username']."', '".$_SESSION['problems']['problemset']."',
   '".$_SESSION['problems']['condition']."', '".$_SESSION['problems']['cid']."',
    ".$_SESSION['problems']['recnum'].", '".$_SESSION['problems']['name']."', '$claimedSet',FALSE)";
  $result = pg_query($dbconn, $query);
  if (!$result) {
    echo "An error occurred. Nothing claimed.\n";
    exit;
  } else {
    $_SESSION['claimed'] = true;
    header('Location: home.php');
  }
  pg_close($dbconn);
}
?>
