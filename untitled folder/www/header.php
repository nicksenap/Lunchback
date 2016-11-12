<!DOCTYPE html>
<html>
<head>
	<title>Recitation Reporter</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<?php if(isset($_SESSION['username'])){ ?>
					<a href="logout.php">
						<button type="button" class="navbar-toggle collapsed btn navbar-btn">
							Log out
						</button>
					</a>
				<?php } ?>
				<a class="navbar-brand" href="index.php">Recitation Reporter</a>
			</div>
			<!-- If user is logged in we show a log out button -->
			<div class="collapse navbar-collapse">
				<?php if(isset($_SESSION['username'])){ ?>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="logout.php">Log out</a></li>
					</ul>
				<?php } ?>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div class="container">
