<?php
    //include 'checkifloggedin.php';
    unset($_COOKIE['loggedInUser']);
    setcookie('loggedInUser', null, -1, '/');

    redirect("login.php");
?>
