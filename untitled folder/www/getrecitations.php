<?php
//Connect to db
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres");
if (!$dbconn) {
  echo "Error: Could not connect to database. \n";
  exit;
}

//If available courses hasn't been set, query db and set it.
if (!isset($_SESSION['courses'])) {
  $query = "SELECT DISTINCT(c.cID), c.name FROM Course c, Recitation r, Takes t WHERE t.cID = c.cID AND t.studentID = '".$_SESSION['username']."'";
  $result = pg_fetch_all(pg_query($dbconn, $query));
  if (!$result) {
    echo "An error occurred. \n";
    exit;
  } else {
    $_SESSION['courses'] = $result;
  }
}

//If a course has been selected, fetch available recitations for the course.
if (isset($_GET['course'])) {
  $query = "SELECT num FROM Recitation WHERE cid = '".$_GET['course']."'";
  $result = pg_fetch_all(pg_query($dbconn, $query));
  if (!$result) {
    echo "An error occurred. No match for selected course was found.\n";
    exit;
  } else {
    $_SESSION['recitations'] = $result;
  }

  //If a course and a recitation has been selected, fetch available groups for the recitation.
  if (isset($_GET['recitation'])) {
    $query = "SELECT name, maxlimit FROM RecitationGroup WHERE num = ".$_GET['recitation']." AND cid = '".$_GET['course']."'";
    $result = pg_fetch_all(pg_query($dbconn, $query));
    if (!$result) {
      echo "An error occurred. No match for selected course+recitation was found.\n";
      exit;
    } else {
      $_SESSION['groups'] = $result;
    }

    //If a course, a recitation and a group has been selected, fetch the problems.
    if (isset($_GET['group'])) {
      $query = "SELECT h.recnum, h.problemset, h.condition, rg.dategiven, rg.name, h.cid FROM hasproblems h, recitationgroup rg WHERE h.cid = rg.cid AND h.recnum = rg.num AND h.cid = '". $_GET['course'] ."' AND h.recnum = ". $_GET['recitation'] ." AND rg.name = '". $_GET['group'] ."'";
      $result = pg_fetch_array(pg_query($dbconn, $query));
      if (!$result) {
        echo "An error occurred. No match for selected course+recitation+group was found.\n";
        exit;
      } else {
        $_SESSION['problems'] = $result;
        $query = "SELECT claimedset, groupname FROM Claims WHERE cid = '" .$_GET['course']. "' AND recnum = " .$_GET['recitation'];
        $result = pg_fetch_all(pg_query($dbconn, $query));
        if ($result) {
          unset($_SESSION['problems']);
          $_SESSION['alreadyClaimed'] = $result;
        }
      }

    } else {
      unset($_SESSION['problems']); //For hiding recitation data.
    }
  } else {
    unset($_SESSION['problems']); //For hiding recitation data.
  }
} else {
  unset($_SESSION['problems']); //For hiding recitation data.
}

pg_close($dbconn);
?>
