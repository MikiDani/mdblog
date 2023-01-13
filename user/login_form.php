<?php 
if (isset($_SESSION['token_error'])) {
  $login_error = $_SESSION['token_error']->response_text;
  unset($_SESSION['token_error']);
}
?>

<div class="col-12 col-sm-7 col-md-5 col-lg-4 m-0 p-0 mt-3 mb-3 bg-warning rounded">
    <form method="POST" action="index.php">
        <h3 class="text-title p-2 rounded-top"><span class="loginicon"><img src="img/icons/login.svg" width="25px" alt="icon"></span>Login</h3>
        <div class="mb-1 p-2">
            <label class="form-label" for="login_usernameoremail">Username or email address</label>
            <input autocomplete="off" class="form-control" type="text" id="login_usernameoremail" name="login_usernameoremail" value="<?php echo login_usernameoremail(); ?>" placeholder="username or email">
        </div>
        <div class="mb-1 p-2">
            <label class="form-label" for="login_password">Password</label>
            <input class="form-control" type="password" id="login_password" name="login_password" value="<?php echo login_password(); ?>" placeholder="password">
        </div>
        <div class="form-check m-2">
            <input class="form-check-input" type="checkbox" id="login_check" name="login_check" <?php echo login_check(); ?>>
            <label class="form-check-label" for="login_check">Im not a robot</label>
        </div>
        <div class="form-text text-danger text-center" id="login_error" name="login_error"><strong><?php isset($login_error) ? print_r($login_error) : false ; unset($login_error); ?></strong></div>
        <div class="text-center mt-2 mb-2"><button class="btn btn-primary" type="submit" name="login_submit">Login</button></div>
    </form>
</div>

<?php
function login_usernameoremail() {
  isset($_POST['login_usernameoremail']) ? $message = $_POST['login_usernameoremail'] : $message = '';
  return $message;
}

function login_password() {
  isset($_POST['login_password']) ? $message = $_POST['login_password'] : $message = '';
  return $message;
}

function login_check() {
  isset($_POST['login_check']) ? $html = "checked" : $html = null ;
  return $html;
}