<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'admin/includes/database.php';

$category = $_GET['category'] ?? null;

//
$query = "SELECT * FROM categories";

$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll();

//
$limit = 2;

$query = "SELECT p.title, p.content, p.created_at, u.username AS author
    FROM posts p
    LEFT JOIN categories_posts cp ON p.id = cp.post_id
    LEFT JOIN categories c ON cp.categorie_id = c.id
    LEFT JOIN users u ON p.user_id = u.id
    ORDER BY created_at DESC
    LIMIT $limit";

$stmt = $pdo->prepare($query);

$stmt->execute();
$latest_posts = $stmt->fetchAll();

//
$params = null;

if ($category) {
    $params = "WHERE c.id = :category";
}

$query = "SELECT p.title, p.content, p.created_at, u.username AS author
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
$posts = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Blog</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rakkas&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="home">

    <section class="hero">
        <h1 class="logo">
            <a href="index.php">Le Blog</a>
        </h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In aut accusamus odio neque delectus ex, eaque consectetur ratione, iusto itaque voluptate nam. At quo aperiam totam illum, accusamus quia beatae!</p>
    </section>

    <section>
        <h2 class="title">Latest blog posts</h2>

        <div class="posts-latest">
            <?php foreach ($latest_posts as $post) : ?>
                <?php include 'includes/card-post.php'; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="all-posts">
        <h2 class="title">All blog posts</h2>

        <ul class="tabs">
            <li class="tab <?php echo (! isset($_GET['category'])) ? 'active' : ''; ?>">
                <a href="/#all-posts">all categories</a>
            </li>
            <?php foreach ($categories as $category) : ?>
                <li class="tab <?php echo (isset($_GET['category']) && $_GET['category'] == $category->id) ? 'active' : ''; ?>">
                    <a href="/?category=<?php echo $category->id; ?>#all-posts"><?php echo $category->name; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="posts-all">

            <?php if (count($posts) > 0) :
                foreach ($posts as $post) :
                    include 'includes/card-post.php';
                endforeach;
            else: ?>
                <p>Aucun posts dans cette catégorie.</p>
            <?php endif; ?>
        </div>
    </section>

</body>
</html>
