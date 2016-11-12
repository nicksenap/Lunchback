<?php
//Enable error reporting
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//Include login script
require_once 'login.php';

//If a user is logged in, redirect to another page
if(isset($_SESSION['username'])){
	header('Location: home.php');
}

//Include header template
include_once 'header.php';

?>
<!-- Display error from login script if any -->
<?php if (!empty($error)) { ?>
	<div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
<?php } ?>

<div class="panel panel-default">
  <div class="panel-heading">Login</div>
  <div class="panel-body">
    <form action="index.php" method="post">
      <fieldset class="form-group">
        <label for="username">KTH ID</label>
        <div class="input-group">
          <input type="text" class="form-control" id="username" placeholder="Enter KTH ID..." name="username" describedBy="emailaddon">
          <span class="input-group-addon" id="emailaddon">@kth.se </span>
        </div>
      </fieldset>
      <fieldset class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password..." name="password">
      </fieldset>
      <input type="submit" class="btn btn-primary" value="Log in" name="submitlogin">
    </form>
  </div>
</div>

<!-- Include footer template -->
<?php include_once 'footer.php';?>
