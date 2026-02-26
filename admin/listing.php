<?php
$page = 'listing';

require_once "includes/session.php";
require_once "includes/database.php";

// VARIABLES
$page = max(1, $_GET['paged']);
$limit = 2;
$offset = ($page - 1) * $limit ?? 1;

// TOTAL POSTS INSIDE DB
$query = "SELECT COUNT(*)
FROM posts";

$stmt = $pdo->prepare($query);
$stmt->execute();
$total = $stmt->fetchColumn();

$total_posts = ceil($total / $limit);

if ($page > $total_posts) {
    header("Location: ?paged=" . $total_posts);
}

// SELECT ALL POSTS W PAGINATION
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
$posts = $stmt->fetchAll();

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
                        <?php foreach ($posts as $r) : ?>
                            <tr>
                                <th>
                                    <a href="/admin/edit.php?p=<?php echo $r->post_id ?>"><?php echo $r->title; ?></a>
                                </th>
                                <td><?php echo $r->categorie_name; ?></td>
                                <td><?php echo $r->author; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($r->created_at)); ?></td>
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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <nav>
                <ul class="pagination">
                    <li class="page-item <?php echo ($page == 1) ? "disabled" : "" ?>">
                        <a class="page-link" href="?paged=<?php echo $page - 1; ?>">&laquo;</a>
                    </li>

                    <?php for ($i=1; $i <= $total_posts; $i++) : ?>
                        <li class="page-item <?php echo ($page == $i) ? "active" : "" ?>">
                            <a class="page-link" href="?paged=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo ($page == $total_posts) ? "disabled" : "" ?>">
                        <a class="page-link" href="?paged=<?php echo $page + 1; ?>">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </section>
    </main>

    <?php include 'includes/admin-sidebar.php'; ?>

    <script src="../source/js/script.js"></script>

</body>
</html>
