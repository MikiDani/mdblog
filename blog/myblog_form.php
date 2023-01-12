<?php
if (isset($_SESSION['myblog_error'])) { $myblog_error=$_SESSION['myblog_error']; unset($_SESSION['myblog_error']); }
// load blog datas
$expecteddatas = ['myblog_name', 'myblog_title', 'myblog_themecategory', 'myblog_startepoch'];

$data = ["userid" => $_SESSION['login']['userid']];
$response = api_post($_SESSION['login']['usertoken'], '?blogs=userblogdatas', $data, false);
$_SESSION['login']['userblogid']=$response->blogid;

$myblog_name=$response->blogname;
$myblog_title=$response->blogtitle;
$myblog_themecategory=$response->name;
$userurl=$response->userurl;
$blogdate = new DateTime("@$response->startepoch");

//load url datas
$username=$_SESSION['login']['username'];
$urldata = $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$separate = "/";
$cut = strtok($urldata, $separate);
$n=0; $puzzle=[]; $link="";
while ($cut !== false) { $puzzle[$n]=$cut; $cut = strtok($separate); $n++; }
for ($m=0; $m<$n-1; $m++) { $link .= $puzzle[$m]; $link.= ($m==0) ? "//" : "/" ; }

$link.= "blog.php?".$userurl;

?>
<h3 class="text-title m-0 p-0 mt-3 p-2 rounded-top"><span class="myblogicon"><img src="img/icons/myblog.svg" width="25px" alt="icon"></span><span class="me-5">My Blog Body<span class="blogdate me-1"><?php echo $blogdate->format('Y-m-d'); ?></span></h3>
<form class="row m-0 p-0 bg-warning" method="POST" action="index.php">
    
    <div class="col-12 col-md-6 mb-3 link text-center">
        <label class="form-label m-0 p-0 mt-2" for="newentrie_title">Link: </label>

        <a class="link inline-block" target="_blank" href="<?php echo $link; ?>"><strong><?php echo $link; ?></strong></a>

    </div>
    <div class="col-12 col-sm-6 mb-3">
        <label class="form-label mt-2" for="myblog_name">Blog name</label>
        <input class="form-control" type="text" name="myblog_name" value="<?php echo $myblog_name; ?>">
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <label class="form-label mt-2" for="myblog_title">Blog title</label>
        <input class="form-control" type="text" name="myblog_title" value="<?php echo $myblog_title; ?>">
    </div>
    <div class="col-12 col-sm-6 mb-1 p-2">
        <label class="form-label" for="myblog_categoryid">Theme category</label>
        <select name="myblog_categoryid" class="form-select">
    <?php echo write_selectform($myblog_themecategory, 'name', 'categoryid', '?blogs=allcat' , false, ''); ?>
        </select>
    </div>
    
    <div class="borderbox col-12 col-sm-6 form-text text-danger text-center"><strong><?php if (isset($myblog_error)) { echo $myblog_error; unset($myblog_error); } ?></strong></div>

    <div class="col-12 col-sm-12 mb-1 p-2 text-center">
        <button type="submit" name="myblog_submit" class="btn btn-primary btn-sm">Modification</button>
    </div>
</form>
<form class="row m-0 p-0 mb-3 bg-warning rounded-bottom" method="POST" action="blog/upload.php" enctype="multipart/form-data">
    <div class="col-3 p-3 text-center">
        <input class="form-check-input" type="checkbox" name="deletefile_check" <?php echo deletefile_check(); ?>>
        <button class="btn btn-primary btn-sm" type="submit" name="bgfiledelete_submit">Delete</button>
    </div>

    <div class="col-6 p-3 text-center">
        <input class="form-control-file form-control-sm" type="file" name="file">
    </div>
    <div class="col-3 p-3 text-center">
        <button class="btn btn-primary btn-sm" type="submit" name="bgfile_submit">Upload Image</button>
    </div>
</form>
<?php

function myblog_check() {
  isset($_POST['myblog_check']) ? $html = "checked" : $html = null ;
  return $html;
}

function deletefile_check() {
    isset($_POST['deletefile_check']) ? $html = "checked" : $html = null ;
    return $html;
}
