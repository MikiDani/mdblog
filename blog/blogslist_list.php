<?php
$arrangements = array("Blog name", 'Blog name DESC', 'User name', 'User name DESC', 'Last entrie', 'Last entrie DESC');

$filterdata="";

if (isset($_POST['filterline_submit'])) {
    unset($_POST['filterline_submit']);

    $categoryid = null;
    $orderby = null;
    $allcat = api_get('none', '?blogs=allcat');

    foreach ($allcat as $cat) { $cat->name==$_POST['filterline_categoryfilter'] ? $categoryid=$cat->categoryid : false ; }
    
    $_POST['filterline_arrangment']=='Blog name' ? $orderby = 'blogname' : false ;
    $_POST['filterline_arrangment']=='Blog name DESC' ? $orderby = 'blogname DESC' : false ;
    $_POST['filterline_arrangment']=='User name' ? $orderby = 'userid' : false ;
    $_POST['filterline_arrangment']=='User name DESC' ? $orderby = 'userid DESC' : false ;
    $_POST['filterline_arrangment']=='Last entrie' ? $orderby = 'maxentrieepoch DESC' : false ;
    $_POST['filterline_arrangment']=='Last entrie DESC' ? $orderby = 'maxentrieepoch' : false ;

    $filterdata = array("orderby" => $orderby, "filterkey" => "categoryid", "filtervalue" => $categoryid);
}

$blogslist = api_post('none','?blogs=allblogs', $filterdata, false);

?>
<h3 class="text-title m-0 p-0 mt-3 p-2 rounded-top"><span class="myblogicon"><img src="img/icons/myblog.svg" width="25px" alt="icon"></span><span class="me-5">Blogs list</span></h3>
<form class="row m-0 p-0 bg-warning rounded-bottom" method="POST" action="index.php">
    <div class="row m-0 p-2 bg-warning text-center">
        <div class="col-2"><label class="form-label" for="filterline_categoryfilter"><span class="textinlineblock mt-2">Category</span></label></div>
        <div class="col-3"><select class="form-select" name="filterline_categoryfilter"><?php echo write_selectform($_POST['filterline_categoryfilter'], 'name', 'name', '?blogs=allcat' , true,"text-select-small"); ?></select></div>
        <div class="col-2"><label class="form-label" for="filterline_arrangment"><span class="textinlineblock mt-2">Arrangment</span></label></div>
        <div class="col-3"><select class="form-select" name="filterline_arrangment">
        <?php echo arrangement_selectform($_POST['filterline_arrangment'],  $arrangements); ?>
        </select></div>
        <div class="col-2"><span class="textinlineblock mt-1"><button type="submit" name="filterline_submit" class="btn btn-primary btn-sm">filter</button></span></div>
    </div>
</form>
<div class="col-12 m-0 p-0 mb-3 bg-light rounded-bottom">
<?php
if ($blogslist == Null) {
    echo "<div class='form-text text-danger text-center mb-1 bg-light'><strong>No results!</strong></div>";
} else {
    echo "<div class='row col-12 m-0 p-0 mt-3'><hr></div>";
    foreach ($blogslist as $blog) {

        $data = ["userid" => $blog->userid];
        $userdata = api_post('none', '?users=oneuser', $data, false);
        $maxentrieepoch = $blog->maxentrieepoch;
        $lastentrieepoch = new Datetime("@$maxentrieepoch");

        ?>
        <div class='row m-0 p-0 text-start'>
            <div class='col-6 col-md-3'><p><strong><?php echo $blog->blogname; ?></strong></p></div>
            <div class='col-6 col-md-3'><p><?php echo $blog->blogtitle; ?></p></div>
            <div class='col-6 col-md-2'><p><strong>Maker: </strong><?php echo $userdata->username; ?></p></div>
            <div class='col-4 col-md-2'><p><strong>Last entrie: </strong><?php echo $lastentrieepoch->format("Y-m-d"); ?></p></div>
                        
            <div class='col-2 col-md-2'><button class='btn btn-primary btn-sm'><a class='whitetextlink' target='_blank' href="blog.php?<?php echo $userdata->userurl; ?>">View blog</a></button></div>
            <div class='row col-12 m-0 p-0'><hr></div>
        </div>
    <?php }
} 

?>
</div>