<?php

function getPosts($pdo) {
    $page = max(1, $_GET['paged'] ?? 1);
    $limit = 20;
    $offset = ($page - 1) * $limit ?? 1;

    $query = "SELECT p.id AS post_id, p.title, p.created_at, u.username AS author, c.name AS categorie_name
    FROM posts p
    LEFT JOIN categories_posts cp ON p.id = cp.post_id
    LEFT JOIN categories c ON cp.categorie_id = c.id
    LEFT JOIN users u ON p.user_id = u.id
    LIMIT :limit
    OFFSET :offset
    ";

    $stmt = $pdo->prepare($query);

    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset',(int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll();
}

function paginatePosts($pdo, $page, $limit, $offset) {
    $query = "SELECT COUNT(*)
    FROM posts";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetchColumn();
}

$query = "SELECT count(*)
FROM posts";
$stmt = $pdo->query($query);
$num_posts = $stmt->fetchColumn();

$query = "SELECT count(*)
FROM users";
$stmt = $pdo->query($query);
$num_users = $stmt->fetchColumn();

function getPost($pdo, $post_id) {
    $query = "SELECT p.*, u.username AS author, c.id AS categorie_id, c.name AS categorie_name
    FROM posts p
    LEFT JOIN categories_posts cp ON p.id = cp.post_id
    LEFT JOIN categories c ON cp.categorie_id = c.id
    LEFT JOIN users u ON p.user_id = u.id
    WHERE p.id = :id ";

    $stmt = $pdo->prepare($query);

    $stmt->execute([':id' => $post_id]);

    return $stmt->fetch();
}

function createPost(PDO $pdo, array $data): int {
    $sql = "INSERT INTO posts (title, content, excerpt, status, thumbnail, user_id)
        VALUES (:title, :content, :excerpt, :status, :thumbnail, :user_id)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':title' => $data['title'],
        ':content' => $data['content'],
        ':excerpt' => $data['excerpt'],
        ':status'=> $data['status'],
        ':thumbnail' => $data['thumbnail'],
        ':user_id' => $data['user_id'],
    ]);

    return (int) $pdo->lastInsertId();
}

function updatePost($pdo, $post_id, $data) {
    $sql = "UPDATE posts p
    LEFT JOIN categories_posts cp ON p.id = cp.post_id
    SET title = :title, content = :content, excerpt = :excerpt, status = :status, thumbnail = :thumbnail, user_id = :user_id, categorie_id = :categorie_id
    WHERE id = :post_id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':title' => $data['title'],
        ':content' => $data['content'],
        ':excerpt' => $data['excerpt'],
        ':status' => $data['status'],
        ':thumbnail' => $data['thumbnail'],
        ':user_id' => $data['user_id'],
        ':post_id' => $post_id,
        ':categorie_id' => $data['categorie_id'],
    ]);
}

function deletePost($pdo, $post_id) {
    $query = "DELETE FROM posts
    WHERE id = :id";

    $stmt = $pdo->prepare($query);

    $stmt->bindValue();

    return $stmt->execute([
        ':id' => $post_id
    ]);
}
