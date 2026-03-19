<?php

function getUsers(PDO $pdo) {
    $query = "SELECT *
    FROM users";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll();
}

function getUserByEmail(PDO $pdo, string $email)
{
    $sql = "SELECT *
    FROM users
    WHERE email = :email OR username = :email
    LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    return $stmt->fetch();
}
