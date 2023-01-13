<?php
if (isset($_SESSION['delete_user']) || isset($_SESSION['nohaveentrie'])) {
    isset($_SESSION['delete_user']) ? $text=$_SESSION['delete_user'] : false ;
    isset($_SESSION['nohaveentrie']) ? $text=$_SESSION['nohaveentrie'] : false ;
    echo "<div class='form-text text-danger text-center mt-3' name='profil_error'><strong>$text</strong></div><div class='text-center mt-2'><form method='POST' action='index.php?inc=home'><button class='btn btn-primary' type='submit' name='ok_submit'>Ok</button></form></div>";
    unset($_SESSION['delete_user']);
    unset($_SESSION['nohaveentrie']);
}
?>

<h3 class="text-title m-0 p-0 p-2 mt-3 rounded-top">
    <span class="myblogicon"><img src="img/icons/myblog.svg" width="25px" alt="icon"></span>
    <span class="me-5">Latest entries</h3>
<div class="row m-0 p-0 bg-white">
<?php 
$lastentries = api_get('none', '?blogs=lastentries');

    foreach ($lastentries as $entrie) {
        $entrieid=$entrie->entrieid;
        $entrietitle=$entrie->entrietitle;
        $entriebody=$entrie->entriebody;
        $username=$entrie->username;
        $userurl=$entrie->userurl;
        $entrieepoch=$entrie->entrieepoch;
        $epochconvert = new Datetime ("@$entrieepoch");
        ?>
        <div class="row m-0 p-0">
            <div class="col-5 p-0 m-0">
                <span class="textmt-2"><?php echo $entrietitle; ?></span>
            </div>
            <div class="col-3 p-0 m-0 text-center">
                <span class="textmt-2"><strong><?php echo $username; ?></strong></span>
            </div>
            <div class="col-2 p-0 m-0">
                <span class="textmt-2"><?php echo $epochconvert->format(" Y-m-d  h:i:s"); ?></span>
            </div>
            <div class="col-2 mt-1 mb-1 text-center">
                <form action='blog.php?<?php echo $userurl ?>' method='post'><input type='hidden' name='entrieid' value='<?php echo $entrieid; ?>'><button class='btn btn-primary btn-sm' type='submit'>View</button></form>
            </div>
        </div>
    <?php } ?>
</div>
<div class="text-title m-0 p-0 p-2 rounded-bottom"></div>

<h3 class="text-title m-0 p-0 mt-3 p-2 rounded-top">
    <span class="myblogicon"><img src="img/icons/search.svg" width="25px" alt="icon"></span>
    <span class="me-5">Search text in entries</h3>
<div class="row m-0 p-0 bg-warning pt-2 pb-2">
    <div class="col-2 text-center">
        <label class="textmt-2" for="search"><strong>Text</strong></label>
    </div>
    <div class="col-5">
        <input type="text" class="form-control" id="search" name="search" placeholder="Search..." autocomplete="off" />
    </div>
    <div class="col-2 text-center">
        <label class="textmt-2" for="location"><strong>Location</strong></label>
    </div>
    <div class="col-3">
        <select class="form-select" id="location" name="location" aria-label="Default select example select-form-sm">
            <option value="entrietitle">Entrie title</option>
            <option value="entriebody">Entrie body</option>
        </select>
    </div>
    <div id="search_result" class="col-12 mt-2 bg-white"></div>
</div>
<div class="text-title m-0 p-0 p-2 mb-3 rounded-bottom"></div>

<script src="js/jquery.min.js" referrerpolicy="no-referrer"></script>
<script>
    
    document.getElementById("location").addEventListener("change", function() {
        document.getElementById("search").value="";
        document.getElementById("search_result").style="display: none";
    });

    $(function() {
        $("#search").keyup(function() {

            var input = $(this).val();
            var location = $("#location").val();

            if(input != ""){
                $.ajax({
                    method: "POST",
                    url: "search_inc.php",
                    data: {input: input, location: location},
                    success: function(data){
                        $("#search_result").html(data);
                        $("#search_result").css("display", "block");
                    }
                })
            } else {
                $("#search_result").css("display", "none");
            }
        })
    })

</script>