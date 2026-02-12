<?php
$page = 'edit';

require_once "includes/session.php";
require_once "includes/database.php";

if (isset($_GET['p'])) {
    $post_id = $_GET['p'];

    $query = "SELECT p.*, u.username AS author, c.name AS categorie_name
    FROM posts p
    LEFT JOIN categories_posts cp ON p.id = cp.post_id
    LEFT JOIN categories c ON cp.categorie_id = c.id
    LEFT JOIN users u ON p.user_id = u.id
    WHERE p.id = :id ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $post_id]);
    $post = $stmt->fetch();

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $query = "DELETE FROM posts
        WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $post_id]);

        header('Location: listing.php');
        exit;
    }
}

$query = "SELECT u.*
FROM users u";

$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll();

if (isset($_POST['action']) && $_POST['action'] === 'publish') {
    var_dump('publish');
}

if (isset($_POST['action']) && $_POST['action'] === 'update') {
    var_dump('update');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Edit</title>
</head>

<body class="<?php echo $page; ?> d-flex flex-row-reverse">

    <main class="min-vh-100 vw-100">
        <header class="admin-header position-sticky d-flex align-items-center justify-content-between p-4">
            <h1>Ajouter un article</h1>
            <a class="btn btn-primary" href="edit.php">Ajouter un nouvel article</a>
        </header>

        <section class="container p-4">
            <form class="row" method="POST" action="" enctype="multipart/form-data" novalidate>
                <div class="col col-lg-8">
                    <label for="title" class="form-label">Titre</label>
                    <input id="title" class="form-control" type="text" name="title" placeholder="Lorem ipsum" value="<?php echo (isset($post)) ? $post->title : ''; ?>" required>

                    <label for="content" class="form-label">Contenu</label>
                    <textarea id="content" class="form-control" name="content" placeholder="lorem ipsum" required><?php echo (isset($post)) ? $post->content : ''; ?></textarea>
                </div>

                <div class="col col-lg-4">
                    <label for="thumbnail">Thumbnail</label>
                    <img src="../assets/images/photo-1761839257961-4dce65b72d99.avif" class="img-thumbnail" alt="">
                    <input id="thumbnail" class="form-control" type="file" name="thumbnail">

                    <label>Catégorie</label>

                    <div class="form-check">
                        <input id="categorie-1" class="form-check-input" type="radio" name="categorie">
                        <label for="categorie-1" class="form-check-label">Catégorie 1</label>
                    </div>
                    <div class="form-check">
                        <input id="categorie-2" class="form-check-input" type="radio" name="categorie">
                        <label for="categorie-2" class="form-check-label">Catégorie 2</label>
                    </div>
                    <div class="form-check">
                        <input id="categorie-3" class="form-check-input" type="radio" name="categorie">
                        <label for="categorie-3" class="form-check-label">Catégorie 3</label>
                    </div>

                    <label for="status" class="form-label">Status</label>
                    <select id="status" class="form-select" name="status">
                        <option value="0" <?php echo (isset($post) || ! $post->status) ? 'selected' : ''; ?>>Brouillon</option>
                        <option value="1" <?php echo ($post->status) ? 'selected' : ''; ?>>Publié</option>
                    </select>

                    <label for="author" class="form-label">Auteur</label>
                    <select id="author" class="form-select" name="author" required>
                        <?php foreach ($users as $user) : ?>
                            <option value="<?php echo $user->id; ?>" <?php echo ($user->id == $_SESSION['user_id'] || $post->user_id) ? 'selected' : ''; ?>><?php echo $user->username; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary" name="action" value="update" data-action="">Mettre à jour</button>
                    <button type="submit" class="btn btn-primary" name="action" value="publish" data-action="">Publier</button>
                    <button type="button" class="btn btn-secondary" data-action="modal.delete">Supprimer</button>
                </div>
            </form>
        </section>
    </main>

    <dialog closedby="any">
        <p>Êtes vous certain de vouloir supprimer ? Toute suppression est définitive.</p>
        <button type="button" data-action="modal.close">Annuler et revenir en arrière</button>

        <form action="" method="POST">
            <button type="submit" name="action" value="delete" data-action="delete.post">Supprimer définitivement</button>
        </form>
    </dialog>

    <?php include 'includes/admin-sidebar.php'; ?>

    <script>
        (() => {
            'use strict'

            const forms = document.querySelectorAll('form')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

    <script>
        // tinymce.init({
        //     selector: 'textarea',
        //     plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        //     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        // });
    </script>
    <script src="assets/js/script.js"></script>

</body>
</html>
