<?php
if (isset($_POST['selectentrie_submit'])) {
    $entrieid = $_POST['selectentrie_submit'];

    $data = ["entrieid" => $entrieid];
    $response = api_post($_SESSION['login']['usertoken'], '?blogs=getoneentrie', $data, true);
    
    $entrietitle = $response->response_text->entrietitle;
    $entriebody = $response->response_text->entriebody;
    $newstr_entriebody=removebr($entriebody);
    
    $entrieepoch = $response->response_text->entrieepoch;
    $ldate = new DateTime("@$entrieepoch");

    $dateelements = [$ldate->format('H'), $ldate->format('i'), $ldate->format('s'), $ldate->format('m'), $ldate->format('d'), $ldate->format('Y')];
    
    ?>
    <h3 id="<?php echo $entrieid; ?>" class="text-title m-0 p-0 p-2 rounded-top text-center"><span class="entriemodicon"><img src="img/icons/entriemod.svg" width="25px" alt="icon"></span><span class="me-5">Modification Blog entrie</h3>
    <form class="row m-0 p-0 mb-3 bg-warning rounded-bottom" method="POST" action="index.php#<?php echo $entrieid ?>">
        <input type="hidden" name="entriemod_entrieid" value="<?php echo $entrieid ?>">
        <div class="col-12 bg-warning rounded">
            <div class="row m-0 p-0 mt-3">
                <label class="form-label m-0 p-0 pt-2 col-3 datespan" for="entriemod_title">Date:</label>
                <div class="datespan2"><input class="form-control" type="number" name="entriemod_year" min="1900" value="<?php echo $dateelements[5]; ?>"></div>
                <div class="datespan1"><input class="form-control" type="number" name="entriemod_month" min="1" max="12" value="<?php echo $dateelements[3]; ?>"></div>
                <div class="datespan1"><input class="form-control" type="number" name="entriemod_day" min="1" max="31" value="<?php echo $dateelements[4]; ?>"></div>
            </div>    
            <div class="row m-0 p-0 mt-2">
                <label class="form-label m-0 p-0 pt-2 col-3 datespan" for="entriemod_title">Time:</label>
                <div class="datespan2"><input class="form-control" type="number" name="entriemod_hour" min="0" max="23" value="<?php echo $dateelements[0]; ?>"></div>
                <div class="datespan1"><input class="form-control" type="number" name="entriemod_minute" min="0" max="59" value="<?php echo $dateelements[1]; ?>"></div>
                <div class="datespan1"><input class="form-control" type="number" name="entriemod_second" min="0" max="59" value="<?php echo $dateelements[2]; ?>"></div>
            </div>
        </div>
        <div class="col-12 bg-warning rounded">
            <div class="mb-3">
                <label class="form-label mt-2" for="entriemod_title">Entrie title</label>
                <input class="form-control mb-2" type="text" name="entriemod_title" value="<?php echo isset($entrietitle) ? $entrietitle : Null ; ?>">
                <label class="form-label" for="entriemod_body">Entrie body</label>
                <textarea class="form-control" rows="11" type="text" name="entriemod_body"><?php echo isset($newstr_entriebody) ? $newstr_entriebody : Null ; ?></textarea>
            </div>
        </div>
        <div class="form-text text-danger text-center entriemoderror mb-3"><strong><?php if (isset($entriemod_error)) { echo $entriemod_error; unset($entriemod_error); } ?></strong></div>
        <div class="col-4 mb-3 text-start">
            <input type="hidden" name="selectentrie_submit" value="<?php echo $entrieid;?>">
            <button type="submit" name="entriemod_submit" class="btn btn-primary btn-sm">Modification</button>
        </div>
        <div class="col-4 mb-3 text-center">
            <input class="form-check-input" type="checkbox" name="entriemoddelete_check" <?php echo deleteentrie_check(); ?>>
            <label class="form-check-label" for="delete_check">Delete</label>
            <button class="btn btn-sm btn-danger" type="submit" name="entriemodcheck_submit" value="delete">Delete</button>
        </div>
        <div class="col-4 mb-3 text-end">
            <button type="submit" name="entrieback_submit" value="<?php echo $entrieid; ?>" class="btn btn-primary btn-sm">Back</button>
        </div>
    </form>
    <?php
} else {
    unset($_POST['selectentrie_submit']);
    header("Refresh:0 url=index.php");
}