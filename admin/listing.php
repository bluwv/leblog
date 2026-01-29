<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page = 'listing';

require_once "includes/session.php";

var_dump($_SESSION["user"] + 150 - time());

if ( time() > $_SESSION["user"] + 150 ) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Listing</title>
</head>

<body class="edit d-flex flex-row-reverse">

    <main class="min-vh-100 vw-100">
        <header class="admin-header d-flex align-items-center justify-content-between p-4">
            <h1>Listing des articles</h1>
            <a class="btn btn-primary" href="edit.php">Ajouter un nouvel article</a>
        </header>

        <section class="container p-4">
            <div class="row gap-4">
                <div class="col col-sm-6 col-md-3 card p-4">
                    <p>Nombre d’articles</p>
                    <p class="fs-1 fw-bold">100</p>
                </div>


                <div class="col col-sm-6 col-md-3 card p-4">
                    <p>Nombre d’utilisateurs</p>
                    <p class="fs-1 fw-bold">2</p>
                </div>
            </div>
        </section>

        <section class="container p-4">

            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Draft</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Archived</a>
                </li>
            </ul>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Auteur</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i < 20; $i++) : ?>
                            <tr>
                                <th>
                                    <a href="/admin/edit.php">Article 1</a>
                                </th>
                                <td>Catégorie 1</td>
                                <td>Admin</td>
                                <td>22/01/2026</td>
                                <td>
                                    <!-- <button class="btn btn-primary">…</button>
                                    <menu>
                                        <li>
                                            <a href="">Voir</a>
                                        </li>
                                        <li>
                                            <a href="">Modifier</a>
                                        </li>
                                        <li>
                                            <a href="">Supprimer</a>
                                        </li>
                                    </menu> -->
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="">Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="">Next</a>
                    </li>
                </ul>
            </nav>
        </section>
    </main>

    <?php include 'includes/admin-sidebar.php'; ?>

    <script src="../source/js/script.js"></script>

</body>
</html>
