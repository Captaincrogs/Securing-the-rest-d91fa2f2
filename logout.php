<?php
    require 'checkiflogedin.php';
    unset($_COOKIE['loggedInUser']);
    setcookie('loggedInUser', null, -1, '/');

    redirect("login.php");
?>
