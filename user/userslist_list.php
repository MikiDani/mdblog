<div class="row p-0 m-0 bg-warning mt-3 rounded-top">
    <div class="col-4 p-2 m-0">
        <form class="m-0 p-0" action="index.php" method="POST">
            <input type="hidden" name="users_orderby" value="username">
            <input class="linkbutton" type="submit" value="Username"></strong>
        </form>
    </div>
    <div class="col-4 p-2 m-0">
        <form class="m-0 p-0" action="index.php" method="POST">
            <input type="hidden" name="users_orderby" value="useremail">
            <input class="linkbutton" type="submit" value="Email"></strong>
        </form>
    </div>
    <div class="col-4 p-2 m-0"></div>
</div>

<div class="row p-0 m-0 bg-light mb-3 rounded-bottom">
<?php
$orderby="";
if (isset($_POST['users_orderby'])) { $orderby=$_POST['users_orderby']; }

$data = ["orderby" => $orderby];
$allusermindatas = api_post('none', '?users=allusersmin', $data, false);

echo "<div class='p-0 m-0'><hr></div>";
foreach($allusermindatas as $user) {
    echo "
    <form class='row m-0 p-0' method='POST' action='index.php'>
    <div class='col-3 p-2 m-0 mt-1 text-center'><strong>$user->username</strong></div>
    <div class='col-3 p-2 m-0 mt-1'>$user->useremail</div>
    <div class='row col-3 m-0 p-0 pt-1 text-center'>"; 
    if (isset($_SESSION['login']['userrank']) && $_SESSION['login']['userrank']=="4") {
    ?>
    <div class="col-7 m-0 p-0 mt-1 me-1">
        <select name="userrank_rank" class="form-select m-0 p-1 text-select-small">
        <?php echo write_selectform($user->rankname, 'rankname', 'id', '?users=allrank', false, "text-select-small"); ?>
        </select>
    </div>
    <div class="col-4 m-0 p-0 mt-1">
        <button type='submit' name='userrank_userid' value="<?php echo $user->id ?>" class='btn btn-primary btn-sm'>Mod</button>
    </div>
    <?php 
    }
    echo "</div>
    <div class='col-3 p-2 m-0 text-center'>".buttoninsert($user->blogid, $user->blogname, $user->userurl)."</div>
    <div class='p-0 m-0'><hr></div>
    </form>";
}
?>
</div>

<?php
function buttoninsert($blogid, $blogname, $userurl) {
    if ($blogid!="" && $blogname!="Unknown") {
        return "
        <button class='btn btn-primary btn-sm'><a class='whitetextlink' target='_blank' href='blog.php?$userurl'>View blog</a></button>
        ";
    }
}
