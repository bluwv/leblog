<?php
$page = 'categories';

require_once "includes/session.php";
require_once "includes/database.php";

$query = "SELECT *
FROM categories";

$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll();

if (isset($_POST['action']) && $_POST['action'] === 'publish') {
    $name = $_POST['name'];

    $query = "INSERT INTO categories (name)
    VALUES (:name)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':name' => $name]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['update'];
    $name = $_POST['name'];

    $query = "UPDATE categories
    SET name = :name
    WHERE id = :id";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':name' => $name, ':id' => $id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['delete'];

    $query = "DELETE FROM categories
    WHERE id = :id";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Catégories</title>
</head>

<body class="<?php echo $page; ?> d-flex flex-row-reverse">

    <main class="min-vh-100 vw-100">
        <header class="admin-header position-sticky d-flex align-items-center justify-content-between p-4">
            <h1>Liste des catégories</h1>
        </header>

        <section>
            <form action="" method="POST">
                <label for="name">Nom de la catégorie</label>
                <input id="name" type="text" name="name" placeholder="name">

                <button type="submit" class="btn btn-primary" name="action" value="publish">Publier</button>
            </form>

           <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <?php foreach ($categories as $categorie) : ?>
                        <tr>
                            <th>
                                <form id="categorie-<?php echo $categorie->id; ?>" action="" method="POST">
                                    <input type="text" name="name" value="<?php echo $categorie->name; ?>"><!-- readonly -->
                                </form>
                            </th>
                            <td>
                                <!-- <button type="button" data-action>Modifier</button> -->
                                <button type="submit" form="categorie-<?php echo $categorie->id; ?>" name="update" value="<?php echo $categorie->id; ?>" data-action>Mettre à jour</button>
                                <button type="button" value="<?php echo $categorie->id; ?>" data-action="modal.delete">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
           </div>
        </section>
    </main>

    <dialog closedby="any">
        <p>Êtes vous certain de vouloir supprimer ? Toute suppression est définitive.</p>
        <button type="button" data-action="modal.close">Annuler et revenir en arrière</button>

        <form action="" method="POST">
            <button type="submit" name="delete" value="" data-action="delete.post">Supprimer définitivement</button>
        </form>
    </dialog>

    <?php include 'includes/admin-sidebar.php'; ?>

    <script src="assets/js/script.js"></script>

</body>
</html>
