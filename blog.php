<?php
session_start();
include_once "backend/session_url.php";
include_once "function_includes.php";

if (isset($_POST['numopen'])) { $numopen=$_POST['numopen']; unset($_POST['numopen']); } else { $numopen = 0; }

$post_entrieid = (isset($_POST['entrieid'])) ? $_POST['entrieid'] : null ;

//echo "<div class='backendtext'>postentrieid:  $post_entrieid</div>";

if (isset($_POST['comment_del'])) {
    $commentid=$_POST['comment_del'];unset($_POST['comment_del']);
    $data = ["commentid" => $commentid];
    $response = api_post($_SESSION['login']['usertoken'], '?comments=delcomment', $data, false);
}

if (isset($_POST['comment_submit']) && isset($_POST['comment_text']) && $_POST['comment_text']!="") {
    $userid=$_POST['comment_userid']; unset($_POST['comment_userid']);
    $entrieid=$_POST['comment_entrieid']; unset($_POST['comment_entrieid']);
    $commenttext=$_POST['comment_text']; unset($_POST['comment_text']);
    //print " userid: $userid  entrieid:  $entrieid  commenttext:  $commenttext  ";
    $data = ["userid" => $userid, "entrieid" => $entrieid, "commenttext" => $commenttext];
    $response = api_post($_SESSION['login']['usertoken'], '?comments=newcomment', $data, false);
}

$url=$_SERVER['QUERY_STRING'];
$querylink = strtok($_SERVER['QUERY_STRING'], '='); //echo $querylink."<br>";

$response = api_get('none', '?users=alluserurl');

foreach ($response as $user) {
    if ($querylink == $user->userurl) {
        $userid = $user->userid;
        $blogusername = $user->username;
        break;
    }
}

if (isset($userid)) {
    // load user blog datas    
    $sendingdata = ["userid" => $userid];
    $blogdatas = api_post('none', '?blogs=blogalldatas', $sendingdata, true);

    $alldata = $blogdatas->response_text;
    $status_code = $blogdatas->status_code;
        
    if ($status_code==400) {
        $_SESSION['nohaveentrie']="You are no posts in your blog yet.";
        header("Refresh:0 url=index.php?inc=home"); die('');
    } else {
        $readdate = $alldata[0]->startepoch;
        $blogcreatedate = new DateTime("@$readdate");
        $alldata[0]->bgimg!=='' ? $bgfilename=$alldata[0]->bgimg : $bgfilename = null ;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
        -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/main.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <title><?php echo $blogusername."'s Blog. ".$alldata[0]->blogname; ?></title>
    </head>
    <body>
    <div class="container-fluid page mt-2">
        <a href="index.php?inc=bloglist"><div class="portal-link"></div></a>
        <div class="row bloghead p-3 rounded-top" style="<?php echo bg_load($bgfilename); ?>">
            <h1 class="link"><p class="textbg textbg-white-color"><?php echo $alldata[0]->blogname; ?></p></h1>
            <h3 class="link"><p class="textbg textbg-white-color"><?php echo $alldata[0]->blogtitle; ?></p></h3>
            <h4 class="title-left2"><p class="textbg textbg-white-color"><span class="writer">Writer:</span><strong><?php echo $alldata[0]->username; ?></strong></p></h4>
            <h4 class="date-right2"><p class="textbg textbg-white-color"><?php echo $blogcreatedate->format('Y-m-d'); ?></p></h4>
        </div>
        <div class="row content justify-content-center">
            <?php
            if ($status_code == 200 || $status_code == 201) {
            ?>
            <div class="accordion m-0 p-0" id="accordionExample">
                <?php
                $num = 0;
                foreach ($alldata as $entrie) {
                    $entriedate = new DateTime("@$entrie->entrieepoch");
                    $entrieid = $entrie->entrieid;
                    $print_entriebody = str_replace("\n", "<br>", $entrie->entriebody);
                    ?>
                    <div id="<?php echo $entrieid; ?>" class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $entrieid; ?>">
                            <button class="accordion-button bg-warning text-black" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $entrieid; ?>" aria-expanded="true" aria-controls="collapse<?php echo $entrieid; ?>">
                                <div class="entriehead">
                                    <span class="title-left"><strong><?php echo $entrie->entrietitle; ?></strong></span>
                                    <span class="date-right"><strong><?php echo $entriedate->format('Y-m-d H:i:s'); ?></strong></span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $entrieid; ?>" class="accordion-collapse collapse <?php echo open_entrie($num, $entrieid, $post_entrieid); ?>" aria-labelledby="heading<?php echo $entrieid; ?>" data-bs-parent="#accordionExample">

                            <div class="accordion-body"><?php echo $print_entriebody; ?></div>

                            <div class="bg-warning m-2 mb-0 p-2 rounded-top">
                                 <?php comments_list($entrie, $url, $num); ?>
                            </div>

                            <div class="row m-0 p-0 bg-warning m-2 mt-0 p-1 rounded-bottom">
                                <?php if (isset($_SESSION['login']['usertoken'])) { ?>
                                    <form action="blog.php?<?php echo $url; ?>" method="POST">
                                        <input type="text" autocomplete="off" name="comment_text" class="message-text form-control form-control-sm">
                                        <input type="hidden" name="comment_userid" value="<?php echo $_SESSION['login']['userid']; ?>">
                                        <input type="hidden" name="comment_entrieid" value="<?php echo $entrieid; ?>">
                                        <input type="hidden" name="entrieid" value="<?php echo $entrieid; ?>">
                                        <input type="hidden" name="numopen" value="<?php echo $num; ?>">
                                        <button type="submit" name="comment_submit" class="message-button btn btn-primary btn-sm mb-2">Send</button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                $num++;
                }
                ?>
            </div>
            <?php
            } else {
                ?><div class="form-text text-danger text-center myblogerror"><strong>There are no entries yet.</strong></div><?php
            }
            ?>
        </div>
        <?php require_once('footer.php') ?>
    </div>
    <?php 
    if (isset($_POST['entrieid'])) { 
        ?>
        <script>
        window.variableEntrieid = "<?php echo $_POST['entrieid'];?>";
        document.getElementById(window.variableEntrieid).scrollIntoView({ behavior: 'auto' });
        </script>
        <?php
        unset($_POST['entrieid']); 
    }
    ?>
    </body>
<?php
} else {
    header("Refresh:0 url=index.php");
}

function comments_list($entrie, $url, $num) {

    $data = ["entrieid" => $entrie->entrieid];
    $response = api_post('none', '?comments=allcomments', $data, false);

    foreach ($response as $comment) {
        
        if (isset($_SESSION['login']['userrank']) && $_SESSION['login']['userrank']==4) {
            $own = true;
        } else {
            if (isset($_SESSION['login']['userid']) && $_SESSION['login']['userid']==$comment->userid ) { $own = true; } else { $own = false; }
        }

        $commentdate=$comment->commentepoch;
        $entrieid=$comment->entrieid;
        $dateconvert = new Datetime("@$commentdate");
        ?>
        <div class="message_box">
            <span class="write-message-div"><strong><?php echo $comment->username ?>: </strong> <?php echo $comment->commenttext ?></span>
            
            <?php if ($own) {
                echo "<form method='POST' action='blog.php?$url'><input type='hidden' name='numopen' value='$num'><input type='hidden' name='entrieid' value='$entrieid'><span class='write-button-div'><button type='submit' name='comment_del' value='$comment->commentid' class='btn btn-primary btn-sm'>Delete</button></span></form>";
            } ?>
            <span class="write-date-div"><strong><?php echo $dateconvert->format("Y-m-d H:i:s"); ?></strong></span>
        </div>
        <?php
    }
}

function bg_load($bgfilename) {
    if ($bgfilename !== Null) {
        echo "background-image: url('img/blogbg/$bgfilename');";
    }
}

function open_entrie($num, $entrieid, $post_entrieid) {
    if ($post_entrieid!==null) {
        $return = ($post_entrieid == $entrieid) ? "show" : false ;
        return $return;
    } else {
        $return = $num==0 ? "show" : false ;
        return $return;
    }
}
