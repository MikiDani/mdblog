<?php 
require "character_convert.php";

//GET
if ($_SERVER['REQUEST_METHOD']=='GET') {

    if ($_GET['blogs'] == 'allcat') {
        $stmt = $pdo->prepare('SELECT * FROM blogcategory');
        $stmt->execute();
        $allcat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data=['response_text' => $allcat, 'status_code' => 200];
        return $data;
    }

    if ($_GET['blogs'] == 'lastentries') {
        $stmt = $pdo->prepare("SELECT entrieid, entrietitle, entriebody, entrieepoch, users.username, blogbody.userurl FROM blogentries
        INNER JOIN blogbody ON blogbody.blogid = blogentries.blogid
        INNER JOIN users ON users.id = blogbody.userid
        ORDER BY blogentries.entrieepoch DESC LIMIT 5");
        $stmt->execute();
        $allcat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data=['response_text' => $allcat, 'status_code' => 200];
        return $data;
    }
    
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $indata = json_decode(file_get_contents('php://input'));

    if ($_GET['blogs']=='userblogdatas') {
        $userid = $indata->userid;
        $stmt=$pdo->prepare("SELECT * FROM blogbody
        INNER JOIN blogcategory ON (blogbody.categoryid = blogcategory.categoryid)
        INNER JOIN users ON (users.id = blogbody.userid)
        WHERE blogbody.userid=?");
        $stmt->execute([$userid]);
        $blogdata = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($blogdata) {
            // find User blogbody
            $data = ["response_text" => $blogdata, "status_code" => 200];
            return $data;
        } else {

            $stmt=$pdo->prepare("SELECT username FROM users WHERE id=?");
            $stmt->execute([$userid]);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $usernamerow=$stmt->fetch();
            $username=$usernamerow['username'];

            $usernameutf = unaccent($username);
            $userurl = strtolower($usernameutf).$userid;

            // insert User blogbody
            $blogid = blogidgenerator($pdo);
            $blogname = "Unknown";
            $blogtitle = "Unknown";
            $categoryid = 8;
            $startepoch = time()+7200;
            $stmt = $pdo->prepare("INSERT INTO blogbody (blogid, userid, blogname, blogtitle, categoryid, startepoch, userurl) VALUES (?,?,?,?,?,?,?)");
            if ($stmt->execute([$blogid, $userid, $blogname, $blogtitle, $categoryid, $startepoch, $userurl])) {
                // Insert ok! Load insert datas and reurn request
                $stmt=$pdo->prepare('SELECT * FROM blogbody 
                INNER JOIN blogcategory ON (blogbody.categoryid = blogcategory.categoryid)
                INNER JOIN users ON (users.id = blogbody.userid)
                WHERE blogbody.blogid=?');
                $stmt->execute([$blogid]);
                $insert_blogdata = $stmt->fetch(PDO::FETCH_ASSOC);
                $data=['response_text' => $insert_blogdata, 'status_code' => 201];
            } else { $data = ["response_text" =>'Error when writing mysql', "status_code" => 500]; };
            return $data;
        }
    }
    
    if ($_GET['blogs']=='mod') {
        $datatable = isset($indata->tabledatas->tablename) ? $indata->tabledatas->tablename : 'error' ;
        $idkeyname = isset($indata->tabledatas->idkeyname) ?  $indata->tabledatas->idkeyname : 'error' ;
        $idvalue = isset($indata->tabledatas->idvalue) ? $indata->tabledatas->idvalue : 'error' ;
        if ($datatable!='error' && $idkeyname!='error' && $idvalue!='error') {

            $expected_datas=array();
            // Blog Body good input variables
            if ($datatable=='blogbody') {
                array_push($expected_datas, 'categoryid', 'blogname','blogtitle', 'bgimg');
            }
            // entriemod good input variables
            if ($datatable=='blogentries') {
                array_push($expected_datas, 'entrietitle', 'entriebody', 'entrieepoch');
            }

            $update_datas = array();
            foreach ($indata->celldatas as $incellkey => $incellvalue) {
                //echo "$incellkey = $incellvalue<br>";
                foreach ($expected_datas as $expectkey) {
                    //echo "incellkey: $incellkey == expectkey: $expectkey<br>";
                    if ($expectkey == $incellkey) {
                        $update_datas[$incellkey]=$incellvalue;
                    }
                }
            }
            
            $upload=true;
            $text="";
            $status_code=200;
            foreach ($update_datas as $updatekey => $updatevalue) {
                
                $isset=$pdo->prepare("SELECT $updatekey FROM $datatable");
                $isset->execute();

                if ($row=$isset->fetch()) {
                    $stmt=$pdo->prepare("UPDATE $datatable SET $updatekey=? WHERE $idkeyname=?");
                    $stmt->execute([$updatevalue, $idvalue]);
                    $text .= $updatekey." has updated.";
                } else {
                    $text .= $updatekey." error update!";
                    $status_code=400;
                }
            }
            return $data = ["response_text" =>$text, "status_code" => $status_code];
        } else { return $data = ["response_text" =>"no have correct tabledatas", "status_code" => 400]; }
    }

    if ($_GET['blogs']=='newentrie') {
        $data=null;
        if (isset($indata->blogid)) {
            if (isset($indata->entrietitle) && isset($indata->entriebody) && $indata->entrietitle!='' && $indata->entriebody!='' ) {
                
                $blogid=$indata->blogid;
                $entrietitle=$indata->entrietitle;
                //$entriebody=$indata->entriebody;
                //$entriebody_enters = nl2br($indata->entriebody);
                $entriebody_enters=$indata->entriebody;
                $entrieepoch = time()+7200;
                              
                $stmt = $pdo->prepare("INSERT INTO blogentries (blogid, entrietitle, entriebody, entrieepoch) VALUES (?,?,?,?)");
                
                if ($stmt->execute([$blogid, $entrietitle, $entriebody_enters, $entrieepoch])) {
                    //Insert ok
                    return $data = ["response_text" => "Blog entrie is inserted", "status_code" => 201];

                } else { return $data = ["response_text" => "Error when writing mysql", "status_code" => 500]; }                
            } else { return $data = ["response_text" => "entrietitle or entriebody is missing", "status_code" => 400]; }
        } else { return $data = ["response_text" => "blogid is missing", "status_code" => 400]; }
    }

    if ($_GET['blogs']=='getoneentrie') {
        if (isset($indata->entrieid)) {
            $entrieid=$indata->entrieid;
            
            $stmt = $pdo->prepare("SELECT * FROM blogentries WHERE entrieid=?");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute([$entrieid]);

            $entriedata = $stmt->fetch();
            if ($entriedata) {
                return $data = ["response_text" => $entriedata, "status_code" => 200];
            } else { return $data = ["response_text" => "There is no entrie with this entrieid", "status_code" => 400]; }
        } else { return $data = ["response_text" => "entrieid is missing", "status_code" => 400]; }
    }

    if ($_GET['blogs']=='getallentries') {
        if (isset($indata->blogid)) {
            $blogid=$indata->blogid;
        
            $stmt = $pdo->prepare("SELECT * FROM blogentries WHERE blogid=? ORDER BY entrieepoch DESC");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute([$blogid]);

            $entriedatas = $stmt->fetchAll();
            if ($entriedatas) {
                return $data = ["response_text" => $entriedatas, "status_code" => 200];
            } else { return $data = ["response_text" => "There is no blog with this blogid", "status_code" => 400]; }
        } else { return $data = ["response_text" => "blogid is missing", "status_code" => 400]; }
    }

    if ($_GET['blogs']=='del') {
        $datatable = isset($indata->tablename) ? $indata->tablename : 'error' ;
        $idkeyname = isset($indata->idkeyname) ?  $indata->idkeyname : 'error' ;
        $idvalue = isset($indata->idvalue) ? $indata->idvalue : 'error' ;
        if ($datatable!='error' && $idkeyname!='error' && $idvalue!='error') {

            $stmt=$pdo->prepare("SELECT * FROM $datatable WHERE $idkeyname = ?");           
            $stmt->execute([$idvalue]);
            $checkid = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($checkid) {
                $isset=$pdo->prepare("DELETE FROM $datatable WHERE $idkeyname = ?");
                $isset->execute([$idvalue]);
                return $data = ["response_text" =>"the deletion has been completed", "status_code" => 200];
            } else {
                return $data = ["response_text" =>"there is no entrie with this id", "status_code" => 400];
            }
            
            return $data = ["response_text" =>$text, "status_code" => $status_code];
        } else { return $data = ["response_text" =>"no give correct tabledatas", "status_code" => 400]; }
    }

    if ($_GET['blogs'] == 'allblogs') {

        $orderby = (isset($indata->orderby) && $indata->orderby!='') ? $indata->orderby : 'startepoch DESC' ;

        $filterkey=isset($indata->filterkey) ? $indata->filterkey : null ;
        $filtervalue=isset($indata->filtervalue) ? $indata->filtervalue : null ;

        //echo "orderby: ".$orderby."<br>";  echo "filterkey: ".$filterkey."<br>"; echo "filtervalue: ".$filtervalue."<br>";
        //die('er');

        if ($filterkey!=null && $filtervalue!=null) {
            $stmt = $pdo->prepare("SELECT *, MAX(entrieepoch) AS maxentrieepoch FROM blogbody
            INNER JOIN blogentries ON (blogentries.blogid = blogbody.blogid)
            WHERE $filterkey=?
            GROUP BY blogbody.blogid
            ORDER BY $orderby");

            $stmt->execute([$filtervalue]);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $blogdatas = $stmt->fetchAll();
        } else {
            $stmt = $pdo->prepare("SELECT *, MAX(entrieepoch) AS maxentrieepoch FROM blogbody
            INNER JOIN blogentries ON (blogentries.blogid = blogbody.blogid)
            GROUP BY blogbody.blogid
            ORDER BY $orderby");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $blogdatas = $stmt->fetchAll();
        }

        return $data=['response_text' => $blogdatas, 'status_code' => 200];
    }

    if ($_GET['blogs']=='blogalldatas') {
        if (isset($indata->userid)) {
            $userid=$indata->userid;
            
            $stmt = $pdo->prepare("SELECT * FROM blogbody 
            INNER JOIN users ON (users.id = blogbody.userid)
            INNER JOIN blogentries ON (blogentries.blogid = blogbody.blogid)
            WHERE userid=? ORDER BY entrieepoch DESC");     // !!! Majd még folyamatosan kikell egészíteni!
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute([$userid]);

            $blogdatas = $stmt->fetchAll();
            if ($blogdatas) {
                return $data = ["response_text" => $blogdatas, "status_code" => 200];
            } else { return $data = ["response_text" => "This user no have entrie", "status_code" => 400]; }
        } else { return $data = ["response_text" => "userid is missing", "status_code" => 400]; }
    }

    if ($_GET['blogs']=='search') {
        if (isset($indata->input) && isset($indata->location)) {
            $input=$indata->input;
            $location=$indata->location;

            $stmt=$pdo->prepare("SELECT $location, entrieid, userurl FROM blogentries
            INNER JOIN blogbody ON blogbody.blogid = blogentries.blogid
            WHERE $location LIKE '%".$input."%'");

            $stmt->setfetchmode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $blogdatas = $stmt->fetchAll();
            return $data = ["response_text" => $blogdatas, "status_code" => 200];
            
        } else { return $data = ["response_text" => "Input or location is missing", "status_code" => 400]; }
    }

}

// functions

function blogidgenerator($pdo) {
    $release=false;
    $stmt = $pdo->prepare('SELECT blogid FROM blogbody');
    $stmt->execute();
    $allblogid = $stmt->fetchAll(PDO::FETCH_ASSOC);
    do {
        $randomize=rand(1111111,9999999);
        foreach($allblogid as $blogid) {
            if ($blogid==$randomize) {
                $release=true;
                break;
            }
        }
    } while ($release);
    return $randomize;
}