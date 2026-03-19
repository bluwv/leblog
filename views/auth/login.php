<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Login</title>
</head>

<body class="login" data-page="<?php echo $page; ?>">

    <div class="login-form">
        <h1>Le Blog</h1>
        <p>Don’t have an account yet? <a href="">Sign up</a></p>

        <form action="" method="POST" novalidate>
            <?php if (isset($error)) : ?>
                <div class="errors">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

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
