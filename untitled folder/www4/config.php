<?php
    // These variables define the client information for Linkedin Api
    $config['callback_url']     =   'http://localhost:8888/www5/index.php'; //Your callback URL

    $config['Client_ID']        =   '756gprlg2slhv0'; // Your LinkedIn Application Client ID
    $config['Client_Secret']    =   'oVwBxJcHUpDHStxM'; // Your LinkedIn Application Client Secret

    // Lunchback info
    // $config['Client_ID']        =   '758m4fest8djkc'; // Your LinkedIn Application Client ID
    // $config['Client_Secret']    =   'olRZhMRPkxOQqb6N'; // Your LinkedIn Application Client Secret

    // These variables define the connection information for your MySQL database
    $username = "lunchback";
    $password = "";
    $host = "127.0.0.1";
    $dbname = "vssf_core";
    
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);}
    catch(PDOException $ex){ die("Failed to connect to the database: " . $ex->getMessage());} 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    header('Content-Type: text/html; charset=utf-8'); 
    session_start(); 
?>