<?php
$page = 'edit';

require_once "includes/session.php";

if ( time() > $_SESSION["user"] + 300 ) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Edit</title>
</head>

<body class="edit d-flex flex-row-reverse">

    <main class="min-vh-100 vw-100">
        <header class="admin-header position-sticky d-flex align-items-center justify-content-between p-4">
            <h1>Ajouter un article</h1>
            <a class="btn btn-primary" href="edit.php">Ajouter un nouvel article</a>
        </header>

        <section class="container p-4">
            <form class="row" method="POST" action="" enctype="multipart/form-data" novalidate>
                <div class="col col-lg-8">
                    <label for="title" class="form-label">Titre</label>
                    <input id="title" class="form-control" type="text" name="title" placeholder="Lorem ipsum" value="" required>

                    <label for="content" class="form-label">Contenu</label>
                    <textarea id="content" class="form-control" name="content" placeholder="lorem ipsum" required></textarea>
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
                        <option value="draft">Brouillon</option>
                        <option value="publish">Publié</option>
                    </select>


                    <label for="author" class="form-label">Auteur</label>
                    <select id="author" class="form-select" name="author" disabled required>
                        <option value="admin" selected>Admin</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Publier</button>
                </div>
            </form>
        </section>
    </main>

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
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

</body>
</html>
