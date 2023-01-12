<?php
session_start();

include_once('../function_includes.php');

// bg file upload
if (isset($_POST['bgfile_submit'])) {
    unset($_POST['bgfile_submit']);
    $upload=false;
    if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"]!="") {
        $temporary = $_FILES["file"]["tmp_name"];
        $fajlmeret = $_FILES["file"]["size"];
        $directorie = "../img/blogbg/";
        $filename = $_FILES["file"]["name"];
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = "bg_".$_SESSION['login']['userblogid'].'.'.end($temp);
        if (!preg_match('/(jpg|png)$/i', $newfilename)) {
            $myblog_error = "Just jpg. and png. you can select a file!";
        } else {
            if ($fajlmeret > 3145728) {
                $myblog_error = "The file is too big!";
            } else {        
                move_uploaded_file($temporary, $directorie.$newfilename);
                $upload=true;
            }
        }
    } else { $myblog_error = "No image selected!"; }

    if ($upload==true) {

        $tabledatas = ['tablename' => 'blogbody', 'idkeyname' => 'blogid', 'idvalue' => $_SESSION['login']['userblogid']];
        $celldatas = ['bgimg' => $newfilename];
        $alldata = ['tabledatas' => $tabledatas, 'celldatas' => $celldatas];

        $response = api_post($_SESSION['login']['usertoken'], '?blogs=mod', $alldata, true);

        if ($response->status_code==200 || $response->status_code==201) {
            $myblog_error = "Image upload successful!";
        } else {
            $myblog_error = "Image upload failed!";
        }
    }
}

// delete background image
if (isset($_POST['bgfiledelete_submit'])) {
    unset($_POST['bgfiledelete_submit']);

    if (isset($_POST['deletefile_check']) && $_POST['deletefile_check']==true) {
        
        $data = ["userid" => $_SESSION['login']['userid']];
        $response = api_post($_SESSION['login']['usertoken'], '?blogs=blogalldatas', $data, false);
        
        $bgimg_load=$response[0]->bgimg;
        
        if ($bgimg_load!=Null) {
            
            $tabledatas = ['tablename' => 'blogbody', 'idkeyname' => 'blogid', 'idvalue' => $_SESSION['login']['userblogid']];
            $celldatas = ['bgimg' => ''];
            $alldata = ['tabledatas' => $tabledatas, 'celldatas' => $celldatas];

            $response = api_post($_SESSION['login']['usertoken'], '?blogs=mod', $alldata, true);

            if ($response->status_code==200 || $response->status_code==201) {
                unlink("../img/blogbg/$bgimg_load");
                $myblog_error="Image deleted successfully!";
            } else {
                $myblog_error = "The background image could not be deleted!";
            }
        } else { $myblog_error="The blog does not have a background image set!"; }

    } else {
        $myblog_error="The delete checkbox is not checked!";
    }
}
$_SESSION['myblog_error']=$myblog_error;
header("Refresh:0 url=../index.php");