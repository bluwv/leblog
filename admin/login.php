<?php
$page = 'login';

require_once "includes/session.php";

// if ( $_SESSION["user"] ) {
//     header('Location: listing.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Login</title>
</head>

<body class="login">

    <div class="login-form">
        <h1>Le Blog</h1>
        <p>Don’t have an account yet? <a href="">Sign up</a></p>

        <form action="">
            <div>
                <label for="email">email address</label>
                <input id="email" type="email" name="email" placeholder="name@gmail.com" required>
            </div>

            <div>
                <label for="password">password</label>
                <input id="password" type="password" name="password" placeholder="*****" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <a href="">I lost password</a>
    </div>

</body>
</html>
