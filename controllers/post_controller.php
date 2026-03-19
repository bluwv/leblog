<?php

require_once '../models/post_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_GET['p'])) {
        $data = [
            'title' => htmlspecialchars(trim($_POST['title'] ?? '')),
            'content' => htmlspecialchars(trim($_POST['content'] ?? '')),
            'excerpt' => htmlspecialchars(trim($_POST['content'] ?? '')),
            'status' => htmlspecialchars(trim($_POST['status'] ?? '')),
            'thumbnail' => htmlspecialchars(trim($_POST['thumbnail'] ?? '')),
            'user_id' => (int) ($_POST['author'])
        ];

        $new_id = createPost($pdo, $data);

        header("Location: /admin/edit.php?p=" . $new_id);
        exit();
    }

    if (! empty($_GET['p'])) {
        $post_id = $_GET['p'];

        $data = [
            'title' => htmlspecialchars(trim($_POST['title'])),
            'content' => htmlspecialchars(trim($_POST['content'])),
            'excerpt' => htmlspecialchars(trim($_POST['content'])),
            'status' => htmlspecialchars(trim($_POST['status'])),
            'thumbnail' => $_POST['thumbnail'], // htmlspecialchars(basename($_FILES["thumbnail"]["name"])),
            'user_id' => htmlspecialchars($_POST['author']),
            'categorie_id' => htmlspecialchars($_POST['categorie']),
        ];

        updatePost($pdo, $post_id, $data);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        deletePost($pdo, $_POST['id']);
        header('Location: posts.php');
        exit;
    }
}

if (isset($_GET['p'])) {
    $post_id = $_GET['p'];

    $post = getPost($pdo, $post_id);
}

$currentpage = max(1, $_GET['paged'] ?? 1);
$limit = 20;
$offset = ($currentpage - 1) * $limit ?? 1;

$posts = getPosts($pdo);
$total = paginatePosts($pdo, $currentpage, $limit, $offset);
