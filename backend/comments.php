<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $indata = json_decode(file_get_contents('php://input'));

    if ($_GET['comments'] == 'allcomments') {
        if (isset($indata->entrieid)) {
            $entrieid=$indata->entrieid;
            
            $stmt = $pdo->prepare("SELECT * FROM blogcomments
            INNER JOIN users ON blogcomments.userid = users.id
            WHERE entrieid=? ORDER BY commentepoch DESC");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute([$entrieid]);
    
            $commentdatas = $stmt->fetchAll();
            return $data = ["response_text" => $commentdatas, "status_code" => 200];
            
        } else { return $data = ["response_text" => "entrieid is missing", "status_code" => 400]; }
    }
    
    if ($_GET['comments'] == 'newcomment') {  
        if (isset($indata->entrieid) && isset($indata->userid) && isset($indata->commenttext)) {
            $userid=$indata->userid;
            $entrieid=$indata->entrieid;
            
            if (strlen($indata->commenttext) > 500) {
                $commenttext=substr($indata->commenttext, 0, 500).'...';
            } else {
                $commenttext=$indata->commenttext;
            }

            $newepochtime = time()+7200;
    
            $stmt = $pdo->prepare("INSERT INTO blogcomments (userid, entrieid, commenttext, commentepoch) VALUES (?,?,?,?)");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute([$userid, $entrieid, $commenttext, $newepochtime]);
            return $data = ["response_text" => "the comment has been saved", "status_code" => 200];
            
        } else { return $data = ["response_text" => "inputs is missing", "status_code" => 400]; }
    }
    
    if ($_GET['comments'] == 'delcomment') {  
        if (isset($indata->commentid)) {
            $commentid=$indata->commentid;
    
            $stmt = $pdo->prepare("DELETE FROM blogcomments WHERE commentid=?");
            $stmt->execute([$commentid]);
            return $data = ["response_text" => "comment has been deleted", "status_code" => 200];
            
        } else { return $data = ["response_text" => "commentid is missing", "status_code" => 400]; }
    }
    
}
