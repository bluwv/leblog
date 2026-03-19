<?php
$page = 'login';

session_start();

require '../config/database.php';
require '../controllers/auth_controller.php';
require '../views/auth/login.php';

if ( time() < $_SESSION["user_last_activity"] + 24 * 60 * 60 ) {
    header('Location: posts.php');
}
