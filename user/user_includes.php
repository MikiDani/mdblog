<?php
// Logout
if ($inc=='logout') {
    unset($_SESSION['login']);
    header("Refresh:0 url=index.php?inc=home");
}

// Login
if (isset($_POST['login_submit'])) {
    $login_error=null;
    $login=true;
    foreach ($_POST as $key => $value) {
        if ($key!="login_submit") {
            if (empty_check($value)) {
                $login=false;
                $login_error = "Incomplete filling! ";
            }
        }
    }

    if (!isset($_POST['login_check'])) { 
        $login=false;
        $login_error.= "Fill the robot checkbox!";
    }
    
    if ($login) {    
        //echo $_POST["login_usernameoremail"]."<br>"; echo $_POST["login_password"]."<br>";
        $data = array("usernameoremail" => $_POST["login_usernameoremail"],"userpassword" => $_POST["login_password"]);
        $options = array('http' => array( 'method' => 'POST', 'content' => json_encode($data), 'header' => "Content-Type: application/json"."Accept: application/json"));
        $context = stream_context_create($options);
        $result = file_get_contents($_SESSION['url']."?users=login", false, $context);
        $response = json_decode($result);        
        if ($response->status_code=='200') {
            $userdata = api_get($response->response_text, '?users=datas');   //token

            $_SESSION['login'] = [
                "userid" => $userdata->id,
                "usertoken" => $response->response_text,
                "username" => $userdata->username,
                "useremail" => $userdata->useremail,
                "userrank" => $userdata->userrank,
                "imglink" => $userdata->imglink,
            ];
            $login_error=null;
            header("Refresh:0 url=index.php?inc=home");
        } else {
            $login_error="Server response: ".$response->response_text.".";
        }
    }
}

//Profil modification
if (isset($_SESSION['login'])) {
    if (isset($_POST['profil_submit']) && $_POST['profil_submit']=='delete') {
        $_POST['delete_submit']=true; $_POST['profil_submit']=true;
        //echo "profil_passwordcheck: ".$_POST['profil_passwordcheck']."<br>";
        if (isset($_POST['profil_passwordcheck']) && $_POST['profil_passwordcheck']!='') {
            $userdata = api_get($_SESSION['login']['usertoken'], '?users=datas');
            if ($_POST['profil_passwordcheck'] == $userdata->userpassword) {
                if (isset($_POST['delete_check'])) {               
                    $response = api_post($_SESSION['login']['usertoken'], '?users=del', 'none', true);
                    if ($response->status_code==200) {
                        unset($_SESSION['login']);
                        unset($_POST['delete_submit']);
                        foreach($_POST as $post) { unset($post); }
                        $_SESSION['delete_user']=$response->response_text;
                        header("refresh:0 url=index.php?inc=home");
                    }
                } else { $profil_error='User delete checkbox is not fill.'; }
            } else { $profil_error='Incorrect password!'; }
        } else { $profil_error='The password is not filled in!'; }   
    }
    //Checking ok! modification datas
    function user_modification() {

        $_POST["profil_useremail"] = str_replace(" ", "", $_POST["profil_useremail"]);
        $_POST["profil_username"] = str_replace(" ", "", $_POST["profil_username"]);

        $data = array("username" => $_POST["profil_username"], "useremail" => $_POST["profil_useremail"], "userinfo" => $_POST["profil_userinfo"], "imglink" => $_POST["profil_radio"]);
        if ($_POST['profil_password']!="") { $data["userpassword"] = $_POST['profil_password']; unset($_POST['profil_password']); unset($_POST['profil_repassword']); }   
        $profil_error=api_post($_SESSION['login']['usertoken'], '?users=mod', $data, false);
        $_SESSION['login']['username'] = $data['username']; $_SESSION['login']['useremail'] = $data['useremail']; $_SESSION['login']['imglink'] = $data['imglink'];
        $_SESSION['user_modified'] = $profil_error;
    }

    // Check All modifications!
    if (isset($_POST['profil_submit'])) {
        if ($_POST['profil_submit']!='delete') {
            $profil_error=null;
            token_check($_SESSION['login']['usertoken']);
            if (isset($_POST['profil_passwordcheck']) && $_POST['profil_passwordcheck']!='') {
                $userdata = api_get($_SESSION['login']['usertoken'], '?users=datas');
                if ($_POST['profil_passwordcheck'] == $userdata->userpassword) {
                    if ($_POST['profil_username']!="" && $_POST['profil_useremail']!="") {
                        
                        $email = $_POST["profil_useremail"];
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                            if ($_POST['profil_password']!='') {
                                if (strlen($_POST['profil_password'])>5) {
                                    if ($_POST['profil_password']==$_POST['profil_repassword']) {
                                        $profil_error=user_modification();  // GO mod
                                    } else { $in = false; $profil_error .= 'The new passwords do not match!'; }
                                } else { $in = false; $profil_error .= 'The new password is not the right length!'; }
                            } else {
                                $profil_error=user_modification();  // GO mod
                            }

                        } else { $profil_error='Invalid email format'; }

                    } else { $profil_error='Incomplete filling!'; }
                } else { $profil_error='Incorrect password!'; }
            } else { $profil_error='The password is not filled in!'; }
        }
    } else {
        // First LOAD
        foreach ($_POST as $post) { unset($post); }
        $userdata = api_get($_SESSION['login']['usertoken'], '?users=datas');
        $_POST['profil_username']=$userdata->username; $_POST['profil_useremail']=$userdata->useremail; $_POST['profil_userinfo']=$userdata->userinfo; $_POST['profil_radio']=$userdata->imglink; $_POST['profil_password']=""; $_POST['profil_repassword']="";
    }
}

//Registration
if (isset($_POST['registration_submit'])) {
    unset($_POST['registration_submit']);
    if (isset($_POST['registration_check'])) {
        if ($_POST['registration_username']!='' && $_POST['registration_useremail']!='' && $_POST['registration_password']!='' && $_POST['registration_repassword']!='') {
            if (strlen($_POST['registration_username'])>5 && strlen($_POST['registration_useremail'])>5 && strlen($_POST['registration_password'])>5 && strlen($_POST['registration_repassword'])>5) {
                if ($_POST['registration_password']!='' && $_POST['registration_repassword']!='') {
                    $data=array("username" => $_POST['registration_username'], "useremail" => $_POST['registration_useremail'], "userpassword" => $_POST['registration_password']);

                    $allresponse = api_post('', '?users=ins', $data, true);
                    $allresponse->status_code==200 ? $regswitch = true : false;
                    $registration_error=$allresponse->response_text;
                    return $registration_error;
                    
                } else { $registration_error='Passwords do not match!'; }
            } else { $registration_error='The minimum is 6 characters!'; }
        } else { $registration_error='The fields are not filled in!'; }
    } else { $registration_error='Use robot button!'; }
}

// Admin userlist rank modification
if (isset($_POST['userrank_rank'])) { 

    $data = ["userid" => $_POST['userrank_userid'], "userrank" => $_POST['userrank_rank']];
    $response = api_post($_SESSION['login']['usertoken'], '?users=rankmod', $data, true);

    $_POST['userrank_userid']==$_SESSION['login']['userid'] ? $_SESSION['login']['userrank']=$_POST['userrank_rank'] : false ;

    unset($_POST['userrank_rank']);
    unset($_POST['userrank_userid']);
}