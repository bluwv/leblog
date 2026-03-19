<?php

require_once '../models/user_model.php';

// $error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {

        $user = getUserByEmail($pdo, $email);

        if ($user && password_verify($password, $user->password)) {

            $_SESSION["user_id"] = $user->id;
            $_SESSION["user_name"] = $user->username;
            $_SESSION["user_role"] = $user->role;
            $_SESSION["user_last_activity"] = time();

            header('Location: /admin/posts.php');
            exit;
        }

        $error = "Vos identifiants sont incorrects.";
    }

    $error = "Les champs sont vides.";
}
