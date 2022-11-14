<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon "></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto ms-4">
                <li class="nav-item menutext"><a class="nav-link active" aria-current="page" href="index.php?inc=home">Home</a></li>
                <li class="nav-item menutext"><a class="nav-link active" aria-current="page" href="index.php?inc=bloglist">Blog List</a></li>
                <li class="nav-item menutext"><a class="nav-link active" aria-current="page" href="index.php?inc=userlist">User List</a></li>
            </ul>
            <ul class="navbar-nav text-end ms-5 me-5">
                <li class="nav-item dropdown"><?php echo namewrite(); ?></li>
            </ul>
        </div>
    </div>
</nav>

<?php
function namewrite() {
    if (isset($_SESSION['login'])) {
        $backtext = $backtext = '<a class="nav-link dropdown-toggle menutext" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="menuavataricon"><img src="img/user/' . $_SESSION['login']['imglink'] . '" width="20px" alt="avatar" title="avatar"></span>' . $_SESSION['login']['username'] . '</a>
        <ul class="dropdown-menu text-end">
        <li><a class="dropdown-item" href="index.php?inc=profil">Profil</a></li>
        <li><hr class="dropdown-divider"></li>
        '.blogwrite().'
        <li><a class="dropdown-item" href="index.php?inc=logout">Log out</a></li>
        </ul>';
        return $backtext;
    } else {
        $backtext = '<li class="nav-item"><span class="icon"><img src="img/icons/login2.svg" width="20px" alt="icon"></span><span class="menutext"><a href="index.php?inc=login">login</a></span></li>';
        $backtext .= '<li class="nav-item"><span class="icon"><img src="img/icons/registration2.svg" width="20px" alt="icon"></span><span class="menutext"><a href="index.php?inc=registration">registration</a></span></li>';
        return $backtext;
    }
}

function blogwrite() {
    if ($_SESSION['login']['userrank']>2) {
        return "<li><a class='dropdown-item' href='index.php?inc=myblog'>My Blog</a></li>";
    }
}