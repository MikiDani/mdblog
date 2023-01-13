<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// you don't need a token key for the query.
if ($_SERVER['REQUEST_METHOD']=='GET' && $_SERVER['QUERY_STRING']=='blogs=allcat' || 
$_SERVER['REQUEST_METHOD']=='GET' && $_SERVER['QUERY_STRING']=='blogs=lastentries' || 
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='blogs=blogalldatas' || 
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='blogs=allblogs' || 
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='blogs=search' ||
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='users=allusersmin' || 
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='comments=allcomments' || 
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='users=login' ||
$_SERVER['REQUEST_METHOD']=='GET' && $_SERVER['QUERY_STRING']=='users=alluserurl' ||
$_SERVER['REQUEST_METHOD']=='GET' && $_SERVER['QUERY_STRING']=='users=allusersmin' ||
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='users=ins' ||
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='users=usernameid' ||
$_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['QUERY_STRING']=='users=oneuser') {
    return true;
}

// check the active tokens
$token = isset(apache_request_headers()['token']) ? apache_request_headers()['token'] : Null ;

$stmt = $pdo->prepare('SELECT * FROM tokens WHERE token = ?');
$stmt->execute([$token]);

if ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
    //echo "Sikerült az azonosítás"; //print_r($row);
    $presentmoment = time();
    // When the token is time out deleted.
    if ($presentmoment > $row['epochend']) {
        $stmt = $pdo->prepare('DELETE FROM tokens WHERE id = ?');
        $stmt->execute([$row['id']]);
        $data=['response_text' => 'Request Timeout', 'status_code' => 408];
        return;
    } else {
        return $data=['response_text' => apache_request_headers()['token'], 'status_code' => 200];
    }
}

$data=['response_text' => 'Unautorized', 'status_code' => 401];
echo json_encode($data); 
die();