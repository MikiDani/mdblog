<?php
// My Blog Modification
if (isset($_POST['myblog_submit'])) {
    unset($_POST['myblog_submit']);
    
    if (isset($_POST['myblog_name']) && isset($_POST['myblog_title']) && $_POST['myblog_name']!='' && $_POST['myblog_title']!='') {
        $myblog_name = $_POST['myblog_name'];
        $myblog_title = $_POST['myblog_title'];
        $myblog_categoryid = $_POST['myblog_categoryid'];
        $blogid = $_SESSION['login']['userblogid'];
        
        $tabledatas = ['tablename' => 'blogbody', 'idkeyname' => 'blogid', 'idvalue' => $blogid];
        $celldatas = ['blogname' => $myblog_name, 'blogtitle' => $myblog_title, 'categoryid' => $myblog_categoryid];
        $alldata = ['tabledatas' => $tabledatas, 'celldatas' => $celldatas];
        
        $response = api_post($_SESSION['login']['usertoken'], '?blogs=mod', $alldata, false);
        $myblog_error = $response;
    } else { $myblog_error='Incomplete filling!'; }
}

// insert new entrie
if (isset($_POST['newentrie_submit'])) {
    unset($_POST['newentrie_submit']);
    if (isset($_POST['newentrie_title'])) { $entrietitle = $_POST['newentrie_title']; }
    if (isset($_POST['newentrie_body'])) { $entriebody = $_POST['newentrie_body']; }

    if ( (isset($_POST['newentrie_title'])) && ($_POST['newentrie_title']!='') && (isset($_POST['newentrie_body'])) && ($_POST['newentrie_body']!='') ) {

        $blogid = $_SESSION['login']['userblogid'];
        $data = ["blogid" => $blogid, "entrietitle" => $entrietitle, "entriebody" => $entriebody];

        $response = api_post($_SESSION['login']['usertoken'], '?blogs=newentrie', $data, true);

        if ($response->status_code==200 || $response->status_code==201) {
            $newentrie_error = $response->response_text;
            unset($entrietitle); unset($entriebody);
        }

    } else { $newentrie_error = "The inputs are not filled!"; }
}

// entrie modification
if (isset($_POST['entriemod_submit'])) {
    unset($_POST['entriemod_submit']);

    if (isset($_POST['entriemod_title']) && isset($_POST['entriemod_body']) && $_POST['entriemod_title']!='' && $_POST['entriemod_body']!='') {

        $entrieid = $_POST['entriemod_entrieid'];
        $entrietitle = $_POST['entriemod_title'];
        $entriebody = $_POST['entriemod_body'];

        $entrieepoch = mktime (($_POST['entriemod_hour']+2), $_POST['entriemod_minute'], $_POST['entriemod_second'], $_POST['entriemod_month'], $_POST['entriemod_day'], $_POST['entriemod_year']);
        
        $tabledatas = ['tablename' => 'blogentries', 'idkeyname' => 'entrieid', 'idvalue' => $entrieid];
        $celldatas = ['entrietitle' => $entrietitle, 'entriebody' => $entriebody, 'entrieepoch' => $entrieepoch];
        $alldata = ['tabledatas' => $tabledatas, 'celldatas' => $celldatas];
        
        $response = api_post($_SESSION['login']['usertoken'], '?blogs=mod', $alldata, true);
        $entriemod_error = $response->response_text;

    } else { $entriemod_error='Incomplete filling!'; }
}

// back mod entrie
if (isset($_POST['entrieback_submit'])) {
    unset($_POST['selectentrie_submit']);
}

// delete entrie
if (isset($_POST['entriemodcheck_submit'])) {
    unset($_POST['entriemodcheck_submit']);
    if (isset($_POST['entriemoddelete_check']) && $_POST['entriemoddelete_check']!="") {

        $data = ["tablename" => "blogentries", "idkeyname" => "entrieid", "idvalue" => $_POST['entriemod_entrieid']];

        $response = api_post($_SESSION['login']['usertoken'], '?blogs=del', $data, true);

        if ($response->status_code == 200 || $response->status_code == 201) {
            unset($_POST['selectentrie_submit']);
            unset($entriemod_error);
        } else {
            $entriemod_error=$response->response_text;
        }
        
    } else { $entriemod_error="Entrie delete checkbox is not fill."; }
    
}