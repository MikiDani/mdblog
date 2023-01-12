<?php
    $post_entrieid = (isset($_POST['entriemod_entrieid'])) ? $_POST['entriemod_entrieid'] : null ;
    
    $data = ["blogid" => $_SESSION['login']['userblogid']];
    $response = api_post($_SESSION['login']['usertoken'], '?blogs=getallentries', $data, true);

    $status_code=$response->status_code;
    $datas=$response->response_text;
?>

<div class="container container-fluid m-0 p-0 mb-3">
    <?php
    if ($status_code==200 || $status_code==201) {
    ?>
    <div class="accordion" id="accordionExample">
    <?php
    $num=0;
    foreach ($datas as $entrie ) {
        $entriedate = new DateTime("@$entrie->entrieepoch");
        $entrieid = $entrie->entrieid;
        $print_entriebody = str_replace("\n", "<br>", $entrie->entriebody);
        ?>
        <form action="index.php#<?php echo $entrieid; ?>" method="post">
            <div id="<?php echo $entrieid; ?>" class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo $entrieid; ?>"><button class="accordion-button bg-warning text-black" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $entrieid; ?>" aria-expanded="true" aria-controls="collapse<?php echo $entrieid; ?>">
                
                <div class="entriehead">
                    <span class="title-left"><strong><?php echo $entrie->entrietitle; ?></strong></span><span class="date-right"><strong><?php echo $entriedate->format('Y-m-d H:i:s'); ?></strong></span>
                </div></button></h2>

                <div id="collapse<?php echo $entrieid; ?>" class="accordion-collapse collapse <?php echo open_entrie($num, $entrieid, $post_entrieid); ?>" aria-labelledby="heading<?php echo $entrieid; ?>" data-bs-parent="#accordionExample"><div class="accordion-body"><?php echo $print_entriebody; ?></div>

                <div class="text-end mb-3 me-3"><button name="selectentrie_submit" value=<?php echo $entrieid; ?> class="btn btn-primary btn-sm">Modificattion</button></div>
                
                </div>
            </div>
        </form>
        <?php
        $num++;
        }
        ?>
    </div>
    <?php
    } else {
    ?>
    <div class="form-text text-danger text-center myblogerror"><strong>There are no entries yet.</strong></div>
    <?php
    }
    ?>
</div>

<?php
if (isset($_POST['entriemod_entrieid'])) {
    ?>
    <script>
    window.variableEntrieid = "<?php echo $_POST['entriemod_entrieid'];?>";
    document.getElementById(window.variableEntrieid).scrollIntoView({ behavior: 'auto' });
    </script>
    <?php
    unset($_POST['entriemod_entrieid']);
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
?>