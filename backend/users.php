<?php
// GET
if ($_SERVER['REQUEST_METHOD']=='GET') {

    // User datas
    if ($_GET['users'] == 'datas') {
        $userdata=loading_user_data($pdo, $token);
        $data=['response_text' => $userdata, 'status_code' => 200];
        return;
    }

    if ($_GET['users'] == 'allrank') {
        $stmt = $pdo->prepare('SELECT * FROM `rank`');
        $stmt->execute();
        $allrank = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data=['response_text' => $allrank, 'status_code' => 200];
        return;
    }

    if ($_GET['users'] == 'allusers') {
        $stmt = $pdo->prepare('SELECT * FROM users
        LEFT JOIN blogbody ON (users.id = blogbody.userid)
        GROUP BY username');
        $stmt->execute();
        $allusers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data=['response_text' => $allusers, 'status_code' => 200];
        return;
    }

    if ($_GET['users'] == 'alluserurl') {
        $usernames = array();

        $stmt = $pdo->prepare("SELECT userurl, userid, username FROM blogbody
        INNER JOIN users ON (users.id = blogbody.userid)");
        $stmt->execute();
        $read = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $data=['response_text' => $read, 'status_code' => 200];
        return;
    }

    if ($_GET['users'] == 'delalltoken') {
        $now = time();
        $stmt = $pdo->prepare("SELECT * FROM tokens");
        $stmt->setfetchmode(PDO::FETCH_ASSOC);
        $stmt->execute();
        while($token = $stmt->fetch()) {
            if ($now>$token['epochend']) {
                $delid = $token['id'];
                $delete = $pdo->prepare("DELETE FROM tokens WHERE id=?");
                $delete->execute([$delid]);
            }
        }
        return $data=['response_text' => 'expired tokens have been deleted', 'status_code' => 200];
    }
}

// POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $indata = json_decode(file_get_contents('php://input'));
    
    // Identification at login
    // Login
    if ($_GET['users'] == 'login') {
        //echo $indata->usernameoremail." "; echo $indata->password;
        $userdata = user_identification($pdo, $indata);
        if ($userdata) {
            // Identification correct
            $tokencode = token_inquest($pdo, $userdata);
            $data=['response_text' => $tokencode, 'status_code' => 200];
        } else {
            $data=['response_text' => 'Autorization error', 'status_code' => 401];
        }
        return;
    }

    // User insert
    if ($_GET['users'] == 'ins') {
        $text = null;
        $check_inputs=['username', 'useremail', 'userpassword'];
        $indata_keys=[];

        $indata->username = str_replace(" ", "", $indata->username);

        foreach ($indata as $indata_key=>$indata_value) {
            array_push($indata_keys, $indata_key);
        }
        $check=true;
        foreach ($check_inputs as $input) {
            if (!in_array($input, $indata_keys)) {
                $text .= "Not exist $input. ";
                $check=false;
            } else {
                if ($input=='username') {
                    if (!value_search_database($pdo, "username", $indata->username, "")) {
                        $check = false;
                        $text .= "Error: Username is exist the database!<br>";
                    }
                }
                if ($input=='useremail') {
                    if (!value_search_database($pdo, "useremail", $indata->useremail, "")) {
                        $check = false;
                        $text .= "Error: Email is exist the database!<br>";
                    }
                }
            }
        }
        if ($check==true) {
            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (username, useremail, userpassword, userrank, imglink) VALUES (?,?,?,?,?)");
            if ($stmt->execute([$indata->username, $indata->useremail, $indata->userpassword, 3, 'none.svg'])) {
                $data=['response_text' => 'You have successfully registered!', 'status_code' => 200];
                return $data;
            } else {
                $text = 'Error in stmt write in mysql!';
            };
        }
        $data=['response_text' => $text, 'status_code' => 400];
        return $data;
    }

    // User modification
    if ($_GET['users'] == 'mod') {
        $data = null;
        $userdata=loading_user_data($pdo, $token);
        $userid=$userdata['id'];
        foreach($userdata as $userkey => $uservalue) {
            if ($indata!=null) {
                foreach($indata as $modkey => $modvalue) {
                    if ($userkey == $modkey && $modvalue!="") {
                        if ($userdata['userrank']!=4 && $modkey=="userrank") {
                            $data = "You cannot change the rank if you are not admin!<br>";
                        } else {
                            if (($modkey=='username' || $modkey=='useremail') && (value_search_database($pdo, $modkey, $modvalue, $userdata[$modkey])==false)) {
                                $data .= $modvalue." is exists!<br>";
                            } else {
                                $stmt = $pdo->prepare("UPDATE users SET $modkey=:modvalue WHERE id=:id");
                                if ($stmt->execute(['modvalue' => $modvalue, 'id' => $userid])) {
                                    $data .= "The ".$modkey." change has taken place.<br>";
                                } else {
                                    $data .= "User changes error!";
                                }
                                //echo "USER: $userkey = $uservalue </br>"; echo "-mod: $modkey = $modvalue </br>"; echo "------</br>";
                            }
                        }
                    }
                }
            } else { $data='no input...'; }
        }
        $data=['response_text' => $data, 'status_code' => 200];
        return $data;
    }

    // user rankmod
    if ($_GET['users'] == 'rankmod') {
        $data = null;
        $userdata=loading_user_data($pdo, $token);
        $moduserid=$indata->userid;
        $moduserrank=$indata->userrank;

        if ($userdata['userrank']=="4") {
            $stmt=$pdo->prepare("UPDATE users SET userrank=? WHERE id=?");
            if ($stmt->execute([$moduserrank, $moduserid])) {
                return $data=['response_text' => 'Userrank is modifided', 'status_code' => 200];
            } else {
                return $data=['response_text' => 'error width insert database', 'status_code' => 400];
            }
        } else {
            return $data = ['response_text' => 'You cannot change the rank if you are not admin!', 'status_code' => 400];
        }
    }

    // User delete
    if ($_GET['users'] == 'del') {
        $data = null;
        $userdata=loading_user_data($pdo, $token);
        $userid=$userdata['id'];
        //if isset delete blogbg.
        $stmt=$pdo->prepare("SELECT bgimg FROM blogbody WHERE userid=?");
        $stmt->execute([$userid]);
        $stmt->setfetchmode(PDO::FETCH_ASSOC);
        if ($imgname=$stmt->fetch()) {
            $delimgname=$imgname['bgimg'];
            if ($delimgname!="") {
                $fileplace = "../img/blogbg/$delimgname";
                if (file_exists($fileplace)) {
                    unlink($fileplace);
                }
            }
        }
        $stmt = $pdo->prepare('DELETE FROM tokens WHERE token=?');
        if ($stmt->execute([$token])) {
            $stmt2 = $pdo->prepare('DELETE FROM users WHERE id=?');
            if ($stmt2->execute([$userid])) {
                $text = "User is deleted";
                $status_code = 200;
            } else {
                $text = "User delete error";
                $status_code = 400;
            }
        } else {
            $text = "Token delete error";
            $status_code = 400;
        }
        $data = ['response_text' => $text, 'status_code' => $status_code];
        return $data;
    }

    // one user datas
    if ($_GET['users'] == 'oneuser') {
        $userid=$indata->userid;
        //echo "userid: ".$userid;
        $stmt=$pdo->prepare("SELECT * FROM users
        INNER JOIN blogbody ON (blogbody.userid = users.id)
        WHERE id=?");
        $stmt->execute([$userid]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $userdata = $stmt->fetch();

        if ($userdata) {
            return $data = ['response_text' => $userdata, 'status_code' => 200];
        } else {
            return $data = ['response_text' => 'No user have this userid', 'status_code' => 400];
        }
    }

    if ($_GET['users'] == 'allusersmin') {

        $orderby = $indata->orderby!="" ? $indata->orderby : 'id' ;

        $stmt = $pdo->prepare("SELECT users.id AS id, username, useremail, userrank, rank.rankname AS rankname, blogid, blogname, userurl FROM users
        LEFT JOIN blogbody ON (users.id = blogbody.userid)
        LEFT JOIN rank ON (users.userrank = rank.id)
        ORDER BY $orderby");
        $stmt->execute();
        $allusers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data=['response_text' => $allusers, 'status_code' => 200];
    }

}

//-- functions start --//

function user_identification ($pdo, $indata) {
    $stmt = $pdo->prepare('SELECT id, username, useremail, userpassword FROM users');
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while ($userdata = $stmt->fetch()) {
        if ($userdata['username'] == $indata->usernameoremail || $userdata['useremail'] == $indata->usernameoremail) {
            if ($userdata['userpassword'] == $indata->userpassword) {
                return $userdata;
            }
        }
    }
    return false;
}

function token_inquest ($pdo, $userdata) {
    $stmt = $pdo->prepare('SELECT * FROM tokens WHERE userid = ?');
    $stmt->execute([$userdata['id']]);
    $tokendata = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tokendata) {
        // Old token owerwrite // print_r($tokendata);
        $id = $tokendata['id'];
        $epochstart = time();
        $epochend = strtotime("+6 hours");
        $token = md5($epochstart.$userdata['username']);
        $stmt = $pdo->prepare('UPDATE tokens SET token=:token, epochstart=:epochstart, epochend=:epochend WHERE id=:id');
        $stmt->execute(['token' => $token, 'epochstart' => $epochstart, 'epochend' => $epochend, 'id' => $id]);
        //echo "Modified!";
        return $token;
    } else {
        // Generate new Token
        $userid = $userdata['id'];
        $epochstart = time();
        $epochend = strtotime("+6 hours");
        $token = md5($epochstart.$userdata['username']);
        $stmt = $pdo->prepare('INSERT INTO tokens (userid, token, epochstart, epochend) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userid, $token, $epochstart, $epochend]);
        //echo "Create!";
        return $token;
    }
}

function loading_user_data ($pdo, $token) {
    $stmt = $pdo->prepare('SELECT users.id, users.username, users.useremail, users.userpassword, users.userrank, users.userinfo, users.imglink FROM users
    INNER JOIN tokens ON (users.id = tokens.userid)
    WHERE tokens.token = ? ');
    $stmt->execute([$token]);
    $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    return $userdata;
}

function value_search_database ($pdo, $tablerow, $searchvalue, $own) {
    $stmt = $pdo->query("SELECT $tablerow FROM users");
    while ($row = $stmt->fetch()) { 
        if ($row[$tablerow] == $searchvalue && $row[$tablerow]!=$own) {
            return false; 
        }
    }
    return true;
}