<?php

// functions.inc.php
function limit_words($words, $limit, $append = ' &hellip;') {
       // Add 1 to the specified limit becuase arrays start at 0
       $limit = $limit+1;
       // Store each individual word as an array element
       // Up to the limit
       $words = explode(' ', $words, $limit);
       // Shorten the array by 1 because that final element will be the sum of all the words after the limit
       array_pop($words);
       // Implode the array for output, and append an ellipse
       $words = implode(' ', $words) . $append;
       // Return the result
       return $words;
}

//
function getAllCategories($pdo) {
    $query = "SELECT * FROM categories";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

//
function getLatestPosts($pdo, $limit = 2) {
    $query = "SELECT p.id, p.title, p.content, p.created_at, u.username AS author
        FROM posts p
        LEFT JOIN categories_posts cp ON p.id = cp.post_id
        LEFT JOIN categories c ON cp.categorie_id = c.id
        LEFT JOIN users u ON p.user_id = u.id
        ORDER BY created_at DESC
        LIMIT $limit";

    $stmt = $pdo->prepare($query);

    $stmt->execute();
    return $stmt->fetchAll();
}

//
function getPosts($pdo, $category) {
    $params = null;

    if ($category) {
        $params = "WHERE c.id = :category";
    }

    $query = "SELECT p.id, p.title, p.content, p.created_at, u.username AS author
        FROM posts p
        LEFT JOIN categories_posts cp ON p.id = cp.post_id
        LEFT JOIN categories c ON cp.categorie_id = c.id
        LEFT JOIN users u ON p.user_id = u.id
        $params
        ORDER BY created_at DESC
        ";

    $stmt = $pdo->prepare($query);

    if ($category) {
        $stmt->bindValue(':category', $category);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

//
function getPost($pdo, $post_id) {
    $query = "SELECT p.*, u.username AS author
    FROM posts p
    LEFT JOIN users u ON p.user_id = u.id
    WHERE p.id = :post_id";

    $stmt = $pdo->prepare($query);
    $stmt->execute(["post_id" => $post_id]);
    return $stmt->fetch();
}
