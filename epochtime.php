<?php

    $entrieepoch = $response->response_text->entrieepoch;
    $dt = new DateTime("@$entrieepoch");  // convert UNIX timestamp to PHP DateTime

    // save load epochtime (hour, minute, second, month, day, year);
    $dateelements = [$ldate->format('H'), $ldate->format('i'), $ldate->format('s'), $ldate->format('m'), $ldate->format('d'), $ldate->format('Y')];
        
    // mktime ( $hour, $minute, $second, $month, $day, $year );
    $testepoch = mktime ($dateelements[0], $dateelements[1], $dateelements[2], $dateelements[3], $dateelements[4], $dateelements[5]);
    echo "<br>mktime testepoch: "; print_r($testepoch); echo "<br>";

    $testclasstime = new Datetime("@$testepoch");

    foreach ($dateelements as $load) { echo "load: ".$load."<br>"; }

    echo "<br>----<br>";
    echo "epochtime: "; print_r($entrieepoch); echo "<br>";
    echo $dt->format('Y-m-d H:i:s');
    echo "<br>Y:";
    echo $dt->format('Y');
    echo "<br>m:";
    echo $dt->format('m');
    echo "<br>d:";
    echo $dt->format('d');
    echo "<br>H:";
    echo $dt->format('H');
    echo "<br>i:";
    echo $dt->format('i');
    echo "<br>s:";
    echo $dt->format('s');
    
    // mktime ( $hour, $minute, $second, $month, $day, $year );
    $testepoch = mktime ( '3', '2', '1', '12', '31', '2222' );
    echo "<br>mktime testepoch: "; print_r($testepoch); echo "<br>";
    
    $loadyear = $dateelements[0];
    $loadmonath = $dateelements[1];
    $loadday = $dateelements[2];

    $loadhour = $dateelements[3];
    $loadminute = $dateelements[4];
    $loadsecond = $dateelements[5];

    $testclasstime = new Datetime("@$testepoch");
    echo "testclasstime: ".$testclasstime->format("Y-m-d H:i:s");
    echo "<br>";