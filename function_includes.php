<?php
/*** Functions ***/

function empty_check ($value) {
    $back=null;
    $value=="" ? $back = true : $back = false ;
    return $back;
}

function token_check($token) {
    $headers = [];
    $headers[] = "token: $token";
    $options = array('http' => array('method' => 'GET', 'header' => $headers));
    $context = stream_context_create($options);
    $result = file_get_contents($_SESSION['url'], false, $context);
    $response = json_decode($result);
    //print_r($response);
    if ($response->status_code=='200') {
        return true;
    } else {
        unset($_SESSION['login']);
        $_SESSION['token_error'] = $response;
        header("Refresh:0 url=index.php?inc=login");
    }
}

function api_get($token, $request) {
    $headers = array();
    $headers[] = "token: $token";
    $options = array('http' => array('method' => 'GET', 'header' => $headers));
    $context = stream_context_create($options);
    $result = file_get_contents($_SESSION['url'].$request, false, $context);
    $response = json_decode($result);
    if ($response->status_code=='200' || $response->status_code=='201') {
        return ($response->response_text);
    } else {
        unset($_SESSION['login']);
        header("Refresh:0 url=index.php?inc=home");
    }
}

function api_post($token, $request, $data, $backswitch) {
    //echo "token: $token<br>"; echo "request: $request<br>"; print_r($data); echo "encode: ".json_encode($data)."<br>";
    $headers = array(
        "token: $token", 
        "Content-Type: application/json",
        "Accept: application/json"
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => $headers,
            'content' => json_encode($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($_SESSION['url'].$request, false, $context);
    $response = json_decode($result);
    
    //echo "<br>1--------<br>"; print_r($result); echo "<br>2--------<br>"; print_r($response); die('END!!!');

    if ($backswitch) { return $response; }
    if ($response->status_code=='200' || $response->status_code=='201') {
        return ($response->response_text);
    } else {
        unset($_SESSION['login']);
        header("Refresh:0 url=index.php?inc=home");
    }
}

function show($num) {
    $return = $num==0 ? "show" : false ;
    return $return;
}

function removebr($data) {
    //$order   = array("\r\n", "\n", "\r"); $replace = '<br />';
    // Processes \r\n's first so they aren't converted twice.
    $order   = array("<br />");
    $replace = '';
    $newdata = str_replace($order, $replace, $data);
    return $newdata;
}

function deleteentrie_check() {
    isset($_POST['entriemoddelete_check']) ? $html = "checked" : $html = null ;
    return $html;
}

// universal selectform
function write_selectform($value, $valuecheck, $backvalue, $apilink, $noneswitch, $textsize) {
    $datas = api_get($_SESSION['login']['usertoken'], $apilink);
    $htmltext = "";
    $noneswitch ? $htmltext .= "<option class='$textsize' value='none'>none</option>" : false ;
    foreach ($datas as $data) {
        if ($data->$valuecheck==$value) {
            $htmltext .= "<option class='$textsize' value='".$data->$backvalue."' selected>".$value."</option>";
        } else {
            $htmltext .= "<option class='$textsize' value='".$data->$backvalue."'>".$data->$valuecheck."</option>";
        }
    }  
    return $htmltext;
}

function arrangement_selectform($value, $arrangements) {

    if ($value=="") { $value="none"; }
    $htmltext='';    
    foreach ($arrangements as $arrangement) {
        if ($arrangement==$value) {
            $htmltext .= "<option selected>$value</option>";
        } else {
            $htmltext .= "<option value='".$arrangement."'>".$arrangement."</option>";
        }
    }  
    //echo "<br>return:<br>"; print_r($htmltext); die('stop');
    return $htmltext;
}