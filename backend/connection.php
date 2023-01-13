<?php

$username = "root";
$password = "";

$pdo = new PDO ("mysql:host=localhost;dbname=mdblog", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

//$pdo->query("SET NAMES utf8");
?>