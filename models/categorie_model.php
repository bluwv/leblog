<?php

function getCategories($pdo) {
    $query = "SELECT c.*
    FROM categories c";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function createCategorie($pdo, $name) {
    $query = "INSERT INTO categories (name)
    VALUES (:name)";

    $stmt = $pdo->prepare($query);
    return $stmt->execute([
        ':name' => $name,
    ]);
}

function updateCategorie($pdo, $id, $name) {
    $query = "UPDATE categories
    SET name = :name
    WHERE id = :id";

    $stmt = $pdo->prepare($query);
    return $stmt->execute([
        ':id' => $id,
        ':name' => $name,
    ]);
}

function deleteCategorie($pdo, $id) {
    $query = "DELETE FROM categories
    WHERE id = :id";

    $stmt = $pdo->prepare($query);

    return $stmt->execute([
        ':id' => $id,
    ]);
}
