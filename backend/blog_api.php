<?php 
// Miklós Dániel MD-Blog | Backend PHP & MySql

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if( !function_exists('apache_request_headers') ) {
    function apache_request_headers() {
    $arh = array();
    $rx_http = '/\AHTTP_/';
    foreach($_SERVER as $key => $val) {
        if( preg_match($rx_http, $key) ) {
        $arh_key = preg_replace($rx_http, '', $key);
        $rx_matches = array();
        // do some nasty string manipulations to restore the original letter case
        // this should work in most cases
        $rx_matches = explode('_', $arh_key);
        if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
            foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
            $arh_key = implode('-', $rx_matches);
        }
        $arh[$arh_key] = $val;
        }
    }
    return( $arh );
    }
}

// CORS
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type:application/json");
$data = "";

require_once "connection.php";

$querylink = strtok($_SERVER['QUERY_STRING'], '=');

// authorization
require_once "authorization.php";

if ($querylink == 'users') { require('users.php'); }
if ($querylink == 'blogs') { require('blogs.php'); }
if ($querylink == 'comments') { require('comments.php'); }

echo json_encode($data);