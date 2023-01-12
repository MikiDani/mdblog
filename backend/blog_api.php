<?php 
// Miklós Dániel MD-Blog | Backend PHP & MySql
// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type:application/json");

require_once "connection.php";

$querylink = strtok($_SERVER['QUERY_STRING'], '=');

// authorization
require_once "authorization.php";

if ($querylink == 'users') { require('users.php'); }
if ($querylink == 'blogs') { require('blogs.php'); }
if ($querylink == 'comments') { require('comments.php'); }

if (isset($data)) { echo json_encode($data); } else { echo "nothing response..."; }