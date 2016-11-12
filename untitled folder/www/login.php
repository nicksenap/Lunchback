<?php
session_start();
$error = "";
//If submit button from login form is pressed...
if (isset($_POST['submitlogin'])) {

  //Check that both username and password is filled in
  if (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Please input both username and password!";

  } else {
    $username=$_POST['username'];
    $password=$_POST['password'];

    $username = stripslashes($username);
    $password = stripslashes($password);
      $pwd = '';
      $row = [];

    
    $dbconn = pg_connect("host=localhost port=5432 dbname=postgres");
    
     if (!$dbconn) {
      $error = "Could not connect to database! Make sure it's running.";
    } else {

         $query = "SELECT name, password FROM Student WHERE id = '$username'";
         $result = pg_query($dbconn, $query);

         $row = pg_fetch_row($result);
         //Check username matches password here
         if ($row[1] == $password) {
             $_SESSION['username'] = $username;
             $_SESSION['name'] = $row[0];
         } else {
             $error = "Username or Password is invalid!";
         }
     }
      pg_close($dbconn);
  }
}
?>
