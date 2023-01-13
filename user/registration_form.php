<div class="col-12 col-sm-7 col-md-5 col-lg-4 m-0 p-0 mt-3 mb-3 bg-warning rounded">
    <?php
    if (isset($regswitch)) {
        unset($regswitch);
        ?>
        <div class="form-text text-danger text-center" id="registration_error" name="registration_error"><strong><?php isset($registration_error) ? print_r($registration_error) : false ; ?></strong></div>
        <div class="text-center mt-2 mb-2"><form method="POST" action="index.php?inc=login"><button class="btn btn-primary" type="submit" name="ok_submit">Ok</button></form></div>
        <?php
        unset($registration_error);
        unset($_SESSION['token_error']);
        foreach($_POST as $post) { unset($post); }
    } else {
    ?>
    <form method="POST" action="index.php">
        <h3 class="text-title p-2 rounded-top"><span class="registrationicon"><img src="img/icons/registration.svg" width="25px" alt="icon"></span>Registration</h3>
        <div class="mb-1 p-2">
            <label class="form-label" for="registration_username">Username</label>
            <input class="form-control" autocomplete="off" type="text" id="registration_username" name="registration_username" value="<?php echo profil_session_write('registration_username'); ?>" placeholder="username">
        </div>
        <div class="mb-1 p-2">
            <label class="form-label" for="registration_useremail">Email</label>
            <input class="form-control" autocomplete="off" type="text" id="registration_useremail" name="registration_useremail" value="<?php echo profil_session_write('registration_useremail'); ?>" placeholder="email">
        </div>
        <div class="mb-1 p-2">
            <label class="form-label" for="registration_password">Password</label>
            <input class="form-control" type="password" id="registration_password" name="registration_password" value="<?php echo profil_session_write('registration_password'); ?>" placeholder="password">
        </div>
        <div class="mb-1 p-2">
            <label class="form-label" for="registration_repassword">Repeat password</label>
            <input class="form-control" type="password" id="registration_repassword" name="registration_repassword" value="<?php echo profil_session_write('registration_repassword'); ?>" placeholder="repeat password">
        </div>
        <div class="form-check m-2">
            <input class="form-check-input" type="checkbox" id="registration_check" name="registration_check" <?php echo registracion_check(); ?>>
            <label class="form-check-label" for="registration_check">Im not a robot</label>
        </div>
        <div class="form-text text-danger text-center" id="registration_error" name="registration_error"><strong><?php isset($registration_error) ? print_r($registration_error) : false ; ?></strong></div>
        <div class="text-center mt-2 pb-2"><button class="btn btn-primary" type="submit" name="registration_submit">Registration</button></div>
    </form>
    <?php } ?>
</div>
<?php
function profil_session_write($inputname) {
    isset($_POST[$inputname]) ? $message = $_POST[$inputname] : $message = null;
    return $message;
}

function registracion_check() {
    isset($_POST['registracion_check']) ? $html = "checked" : $html = null ;
    return $html;
}