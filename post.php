<?php

include_once 'config/database.php';
include_once 'includes/home.php';

$post_id = $_GET['p'];

$post = getPost($pdo, $post_id);
$latest_posts = getLatestPosts($pdo, 3);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single article</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rakkas&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <h1 class="logo">
        <a href="index.php">Le Blog</a>
    </h1>

    <section class="single-banner">
        <div>
            <span><?php echo date('d/m/Y H:i:s', strtotime($post->created_at)); ?></span>
            <h1 class="title"><?php echo $post->title; ?></h1>
            <p><?php echo htmlspecialchars_decode($post->excerpt); ?></p>
            <span><?php echo $post->author; ?></span>
        </div>

        <img src="admin/uploads/<?php echo $post->thumbnail; ?>" width="600" height="400" alt="">
    </section>

    <section class="single-content">
        <?php echo htmlspecialchars_decode($post->content); ?>
        <!-- <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Qui dolores ullam architecto, porro culpa, reprehenderit sapiente omnis perspiciatis at harum impedit. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Qui dolores ullam architecto, porro culpa, reprehenderit sapiente omnis perspiciatis at harum impedit.</p>

        <div>
            <blockquote>
                <p>“ Lorem ipsum dolor sit, amet consectetur adipisicing elit. Qui dolores ullam architecto, porro culpa, reprehenderit sapiente omnis perspiciatis at harum impedit. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Qui dolores ullam architecto, porro culpa, reprehenderit sapiente omnis perspiciatis at harum impedit. “</p>
            </blockquote>
            <p>- Nom Prénom, Job title</p>
        </div>

        <img src="assets/images/photo-1761839257961-4dce65b72d99.avif" alt="">

        <p>Asperiores dolorem, molestiae, ipsa cumque laboriosam saepe, architecto doloremque labore corporis id natus obcaecati optio vitae molestias. Eligendi voluptatum provident corrupti? Provident, excepturi, sequi molestiae ut iste exercitationem, quasi quibusdam temporibus repellat sint aliquam in reiciendis pariatur.</p>

        <p>Laudantium obcaecati eligendi mollitia consequatur quidem, eos porro saepe placeat temporibus, facere quia unde aperiam! Fugit aperiam praesentium dolore, quam doloremque consectetur assumenda similique quaerat molestias!</p>

        <p>Sunt, numquam non. Fugiat commodi, nemo similique, perspiciatis vitae tenetur architecto ipsam a vel laborum accusamus fuga quos repudiandae vero labore, ut iste doloribus nihil corporis nostrum ea reprehenderit.</p>

        <h3>A quaerat, vitae eius asperiores debitis tempora distinctio</h3>

        <p>A quaerat, vitae eius asperiores debitis tempora distinctio, similique provident consequuntur et consectetur aspernatur eos iste officiis dolor iusto, hic ipsum atque molestiae officia rem id. Laborum ea nulla ullam perferendis vero doloribus, voluptate nihil sunt odio, mollitia hic quae repellendus vel, eos eaque.</p> -->
    </section>

    <div class="posts-latest">
        <?php foreach ($latest_posts as $post) : ?>
            <?php include 'includes/card-post.php'; ?>
        <?php endforeach; ?>
    </div>

</body>
</html>
