<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ( time() > $_SESSION["user_last_activity"] + 24 * 60 * 60 ) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
} else {
    $_SESSION["user_last_activity"] = time();
}
