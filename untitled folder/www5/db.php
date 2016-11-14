<?php
define('DB_SERVER', '127.0.0.1'); // Database server
define('DB_USERNAME', 'lunchback'); // Database Username
define('DB_PASSWORD', ''); // Database Password
define('DB_DATABASE', 'vssf_core'); // Database Name
$connection = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); // connecting with database
?>