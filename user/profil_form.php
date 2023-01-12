<?php
if (isset($_SESSION['user_modified'])) { $profil_error=$_SESSION['user_modified']; unset($_SESSION['user_modified']); }

if (isset($_SESSION['login'])) {
    ?>
    <form class="row mt-3 mb-3" method="POST" action="index.php">
        <h3 class="text-title p-2 m-0 rounded-top"><span class="profilicon"><img src="img/icons/profil.svg" width="25px" alt="icon"></span>User Profil</h3>

        <div class="row col-12 col-sm-6 bg-warning pt-2 m-0 pt-1">
            <label class="form-label" for="profil_username">Username</label>
            <input class="form-control" type="text" id="profil_username" name="profil_username" autocomplete="off" value="<?php echo profil_session_write('profil_username'); ?>">
        </div>

        <div class="row col-12 col-sm-6 bg-warning pt-2 m-0 pt-1">
            <label class="form-label" for="profil_useremail">Email address</label>
            <input class="form-control" type="text" id="profil_useremail" name="profil_useremail" autocomplete="off" value="<?php echo profil_session_write('profil_useremail'); ?>">
        </div>

        <div class="row col-12 col-sm-6 bg-warning m-0 pt-2">
            <?php
            $avatarpics = ['none.svg','avatar2.svg','avatar3.svg', 'avatar7.svg', 'avatar8.svg', 'avatar4.svg','avatar5.svg','avatar6.svg'];
            $n=0;
            foreach ($avatarpics as $name) {
                $_POST['profil_radio']==$name ? $checked='checked' : $checked=null ;
                echo "<div class='col-3 text-center p-0 m-0'><img class='profilavatar' src='img/user/$name' alt='avatar$n'><input type='radio' class='form-check-input mb-1' id='radio$n' name='profil_radio' value='$name' $checked></div>";
                $n++;
            }
            ?>
        </div>
                        
        <div class="row col-12 col-sm-6 bg-warning pt-2 m-0 pt-1">
            <label class="form-label bg-warning" for="profil_userinfo">User rank: <strong><?php echo strtoupper(rank_write($_SESSION['login']['userrank'])); ?></strong></label>
            <label class="form-label bg-warning" for="profil_userinfo">User info</label>
            <textarea rows="8" class="form-control mb-2" type="text" id="profil_userinfo" name="profil_userinfo"><?php echo profil_session_write('profil_userinfo'); ?></textarea>
        </div>

        <div class="col-12 col-sm-6 bg-warning text-center">
            <input class="form-check-input" type="checkbox" id="delete_check" name="delete_check" <?php echo delete_check(); ?>>
            <label class="form-check-label" for="delete_check"> Delete profil </label>
            <button class="btn btn-sm btn-danger" type="submit" name="profil_submit" value="delete">Delete</button>
            <!-- error text -->
            <div class="form-text text-danger text-center" id="profil_error" name="profil_error"><strong><?php isset($profil_error) ? print_r($profil_error) : false ; ?></strong></div>
        </div>

        <div class="row col-12 col-sm-6 bg-warning pt-2 m-0 pt-1">
            <label class="form-label" for="profil_passwordcheck">Password</label>
            <input class="form-control" type="password" id="profil_passwordcheck" name="profil_passwordcheck" value="<?php echo profil_session_write('profil_passwordcheck'); ?>">
        </div>

        <div class="col-12 bg-warning rounded-bottom pb-2">
            <div class="row text-center">
                <div class="col-6"><button class="btn btn-sm btn-danger mt-2 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Password change</button></div>                
                <div class="col-6"><button class="btn btn-sm btn-primary mt-2 mb-2 ml-5" type="submit" name="profil_submit">Modification</button></div>
            </div>
            <div class="row m-0 collapse rounded-left" id="collapseExample">  
                <div class="col-6 mb-1 p-2">
                    <label class="form-label" for="profil_password">New password</label>
                    <input class="form-control" type="password" id="profil_password" name="profil_password" value="<?php echo profil_session_write('profil_password'); ?>">
                </div>
                <div class="col-6 mb-1 p-2">
                    <label class="form-label" for="profil_repassword">Repeat new password</label>
                    <input class="form-control" type="password" id="profil_repassword" name="profil_repassword" value="<?php echo profil_session_write('profil_repassword'); ?>">
                </div>
            </div>
        </div>
    </form>
<?php 
}

function profil_session_write($inputname) {
    isset($_POST[$inputname]) ? $message = $_POST[$inputname] : $message = null;
    return $message;
}

function delete_check() {
    isset($_POST['delete_check']) ? $html = "checked" : $html = null ;
    return $html;
}

function rank_write($rankid) {
    $load = api_get($_SESSION['login']['usertoken'], '?users=allrank');    
    foreach($load as $rank) {
        //print_r($rank);
        //echo $rank->id." - "; echo $rank->rankname."<br>";
        if ($rankid==$rank->id) {
            return $rank->rankname;
        }
    }
}