<h3 id="newentrie" class="text-title m-0 p-0 p-2 rounded-top text-center"><span class="newentrieicon"><img src="img/icons/newentrie.svg" width="25px" alt="icon"></span><span class="me-5">Insert new Blog entrie</h3>
<form class="row m-0 p-0 mb-3 bg-warning rounded-bottom" method="POST" action="index.php#newentrie">
    <div class="col-12 bg-warning rounded">
        <div class="mb-3">
            <label class="form-label mt-2" for="newentrie_title">Entrie title</label>
            <input class="form-control" type="text" name="newentrie_title" value="<?php echo isset($entrietitle) ? $entrietitle : Null ; ?>">
            <label class="form-label mt-2" for="newentrie_body">Entrie name</label>
            <textarea class="form-control" rows="10" type="text" name="newentrie_body"><?php echo isset($entriebody) ? $entriebody : Null ; ?></textarea>
        </div>
    </div>
    <div class="form-text text-danger text-center newentrieerror"><strong><?php if (isset($newentrie_error)) { echo $newentrie_error; unset($newentrie_error); } ?></strong></div>
    <div class="mb-1 p-2 text-center">
        <button type="submit" name="newentrie_submit" class="btn btn-primary btn-sm">Insert entrie</button>
    </div>
</form>

