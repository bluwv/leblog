<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Edit</title>
</head>

<body class="<?php echo $page; ?> d-flex flex-row-reverse" data-page="<?php echo $page; ?>">

    <main class="min-vh-100 vw-100">
        <header class="admin-header position-sticky d-flex align-items-center justify-content-between p-4">
            <h1>Ajouter un article</h1>
            <a class="btn btn-primary" href="edit.php">Ajouter un nouvel article</a>
        </header>

        <section class="container p-4">
            <form class="row" method="POST" action="" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="thumbnail" value="PHOTO-2026-03-09-15-26-33 2.jpg">

                <div class="col col-md-8 col-lg-9">
                    <label for="title" class="form-label">Titre</label>
                    <input id="title" class="form-control" type="text" name="title" placeholder="Lorem ipsum" value="<?php echo (isset($post)) ? $post->title : ''; ?>" required>

                    <label for="content" class="form-label">Contenu</label>
                    <textarea id="content" class="form-control" name="content" placeholder="lorem ipsum" required><?php echo (isset($post)) ? $post->content : ''; ?></textarea>
                </div>

                <div class="col col-md-4 col-lg-3">
                    <fieldset class="my-4">
                        <label for="thumbnail">Thumbnail</label>
                        <img src="uploads/<?php echo (isset($post)) ? $post->thumbnail : ''; ?>" class="img-thumbnail d-block ratio ratio-4x3" alt="">
                        <input id="thumbnail" class="form-control" type="file" name="" id="thumbnail">
                    </fieldset>

                    <fieldset class="my-4">
                        <label>Catégorie</label>

                        <?php foreach ($categories as $category) : ?>
                            <div class="form-check">
                                <input id="categorie-<?php echo $category->id; ?>" class="form-check-input" type="radio" name="categorie" value="<?php echo $category->id; ?>" <?php echo (isset($post) && $post->categorie_id == $category->id) ? 'checked' : ''; ?>>
                                <label for="categorie-<?php echo $category->id; ?>" class="form-check-label"><?php echo $category->name; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>

                    <fieldset class="my-4">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select" name="status">
                            <option value="0" <?php echo (isset($post) && ! $post->status) ? 'selected' : ''; ?>>Brouillon</option>
                            <option value="1" <?php echo (isset($post) && $post->status) ? 'selected' : ''; ?>>Publié</option>
                        </select>

                        <label for="author" class="form-label">Auteur</label>
                        <select id="author" class="form-select" name="author" required>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user->id; ?>" <?php echo (isset($post) && $post->user_id) ? 'selected' : ''; ?>><?php echo $user->username; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <div class="d-flex gap-2 mt-4">
                            <?php if (isset($_GET['p'])) : ?>
                                <button type="submit" class="btn btn-primary" name="action" value="update" data-action="">Mettre à jour</button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-primary" name="action" value="publish" data-action="">Publier</button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-secondary" data-action="modal.delete">Supprimer</button>
                        </div>
                    </fieldset>

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

    <script src="assets/js/script.js"></script>

</body>
</html>
