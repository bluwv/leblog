<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Blog</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <section>
        <h1>Le Blog</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In aut accusamus odio neque delectus ex, eaque consectetur ratione, iusto itaque voluptate nam. At quo aperiam totam illum, accusamus quia beatae!</p>
    </section>

    <section>
        <h2>Latest blog posts</h2>

        <?php for ($i=0; $i < 4; $i++) : ?>
            <?php include 'includes/card-post.php'; ?>
        <?php endfor; ?>
    </section>

    <section>
        <h2>All blog posts</h2>

        <ul>
            <li>
                <a href="">all categories</a>
            </li>
            <li>
                <a href="">categorie</a>
            </li>
            <li>
                <a href="">categorie</a>
            </li>
            <li>
                <a href="">categorie</a>
            </li>
        </ul>


        <?php for ($i=0; $i < 12; $i++) : ?>
            <?php include 'includes/card-post.php'; ?>
        <?php endfor; ?>
    </section>

</body>
</html>
