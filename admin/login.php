<?php
$page = 'login';

session_start();
require_once "includes/database.php";

if ( ! empty($_POST) ) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT *
    FROM users
    WHERE email = :email OR username = :email ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':email' => $email]);
    $response = $stmt->fetch();

    if ( password_verify($password, $response->password) ) {
        $_SESSION["user_id"] = $response->id;
        $_SESSION["user_name"] = $response->username;
        $_SESSION["user_role"] = $response->role;
        $_SESSION["user_last_activity"] = time();

        header('Location: listing.php');
        exit;
    } else {
        // AJOUTER MESSAGE FAIL
    }

}
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

        <form action="" method="POST" novalidate>
            <div>
                <label for="email">email address</label>
                <input id="email" type="email" name="email" placeholder="name@gmail.com" value="<?php echo (!(empty($_POST))) ? $_POST['email'] : ''; ?>" required>
            </div>

            <div>
                <label for="password">password</label>
                <div>
                    <input id="password" type="password" name="password" placeholder="*****" value="<?php echo (!(empty($_POST))) ? $_POST['password'] : ''; ?>" required>
                    <button type="button" data-show-password>Show</button>
                </div>
            </div>

            <button type="submit">Login</button>
        </form>

        <a href="">I lost password</a>
    </div>

    <script src="assets/js/script.js"></script>

</body>
</html>
