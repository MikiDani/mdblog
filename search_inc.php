<?php
    require "backend/connection.php";
    require "backend/session_url.php";
    require "function_includes.php";

    if(isset($_POST["input"])) {

        $input = $_POST["input"];
        $location = $_POST["location"];

        // echo "input: ".$input."<br>"; echo "location: ".$location."<br>";

        $data = ["input" => $_POST["input"], "location" => $_POST["location"]];

        $response = api_post('none', '?blogs=search', $data, false);

        $redata = "";

        if ($response!=null) {
            echo "<div class='col-12'><hr></div>";
            foreach ($response as $row) {
                if ($location=='entrietitle') { $redata = $row->entrietitle; }
                if ($location=='entriebody') { $redata = $row->entriebody; }
                $resulttext = str_replace($input,"<strong>$input</strong>", $redata);
                $entrieid = $row->entrieid;
                $userurl = $row->userurl;
                ?>
                <div class='row m-0 p-0'>
                    <div class='col-10'><?php echo $resulttext; ?></div>
                    <div class='col-2'>
                        <form action='blog.php?<?php echo $userurl ?>' method='post'><input type='hidden' name='entrieid' value='<?php echo $entrieid; ?>'><button class='btn btn-primary btn-sm' type='submit'>View</button></form>
                    </div>
                </div>
                <div class='col-12'><hr></div>
                <?php
            }
        } else { echo "<div><h6 class='text-center text-danger mt-3'>No results!</h6></div>"; }
    
    } else { echo "Error"; }
    
?>

    