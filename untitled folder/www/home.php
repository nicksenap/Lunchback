<?php
session_start();

if(!isset($_SESSION['username'])){
	header('Location: index.php');
}

include_once 'header.php';
include_once 'submitclaim.php';

include_once 'getrecitations.php';

?>
<?php if (!isset($_SESSION['loginbanner'])) { ?>
<div class="alert alert-info" role="alert"><?php echo "Successfully logged in  <strong>".$_SESSION['name']."</strong>!"; ?></div>
<?php $_SESSION['loginbanner'] = false; } ?>
<?php if (isset($_SESSION['claimed'])) { ?>
<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Sucessfully claimed problems.</div>
<?php unset($_SESSION['claimed']); } ?>
<div class=""><h1>Welcome <?php echo $_SESSION['name'] ?>!</h1><p>
  Use the buttons below to select a recitation to submit claims to.
</p></div>
<div class="page-header">
  <h2>Recitations</h2>

  <!-- Course select -->
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      if (isset($_GET['course'])) {
        echo $_GET['course']."";
      } else {
        echo "Select course";
      }
      ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
      //Print out all courses available as a list.
      foreach ($_SESSION['courses'] as $course) {
          echo "<li><a href='?course=" . $course['cid'] . "'>";
          echo $course['cid'] . " - " . $course['name'];
          echo "</a></li>";
      }
      ?>
    </ul>
  </div>

  <!-- Recitation select -->
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle <?php if(!isset($_GET['course'])){ echo "disabled"; }?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      if (isset($_GET['recitation'])) {
        echo "Recitation ".$_GET['recitation'];
      } else {
        echo "Select recitation";
      }
      ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
      //Print out all recitations available for a course as a list.
      foreach ($_SESSION['recitations'] as $recitation) {
          echo "<li><a href='?course=" . $_GET['course'] . "&recitation=" . $recitation['num'] . "'>";
          echo "Recitation " . $recitation['num'];
          echo "</a></li>";
      }
      ?>
    </ul>
  </div>

  <!-- Group select -->
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle <?php if(!(isset($_GET['course']) && isset($_GET['recitation']))){ echo "disabled"; }?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      if (isset($_GET['group'])) {
        echo "Group ".$_GET['group'];
      } else {
        echo "Select group";
      }
      ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
      //Print out all groups available for a course+recitation as a list.
      foreach ($_SESSION['groups'] as $group) {
          echo "<li><a href='?course=" . $_GET['course'] . "&recitation=" . $_GET['recitation'] . "&group=" . $group['name'] . "'>";
          echo "Group " . $group['name'];
          echo "</a></li>";
      }
      ?>
    </ul>
  </div>
</div>

<?php if (isset($_SESSION['alreadyClaimed']) && $_SESSION['alreadyClaimed'] != null) { ?>
<div class="alert alert-warning" role="alert">
  <?php
    echo "Already claimed this recitation! (Group ". $_SESSION['alreadyClaimed'][0]['groupname'] .")";
    echo "<br/>";
    echo "You claimed: ".$_SESSION['alreadyClaimed'][0]['claimedset'];
    /*echo "<br/>";
    echo "Your score: ";*/
  ?>
</div>
<?php unset($_SESSION['alreadyClaimed']); } ?>

<?php if (isset($_SESSION['problems']) && $_SESSION['problems'] != null) { ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Recitation <?php echo $_SESSION['problems']['recnum'] ?> <span class="pull-right">Group <?php echo $_SESSION['problems']['name']; ?></span></h3>
  </div>
  <div class="panel-body">
    <form class="" action="home.php" method="post">
      <div class="row">
        <?php
        $problems = preg_split("/[\d]/", $_SESSION['problems']['problemset']);
        for ($i=1; $i < count($problems); $i++) {
          echo "<div class='col-md-2'><div class='panel panel-default'><div class='panel-body'><strong>Problem ".($i)."</strong><br/>";
          $probs = str_split($problems[$i]);
          foreach ($probs as $val) {
            if ($val != "") {
              echo strtoupper($val)." <input type='checkbox' name='$i$val'/><br/>";
            }
          }
          echo "</div></div></div>";
        }
        ?>
      </div>
      <button type=submit value="Lock in claims" name="submitclaims" class="btn btn-danger"/><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Lock in claims</button>
    </form>
  </div>
</div>
<?php } ?>
<?php
include_once 'footer.php';
?>
