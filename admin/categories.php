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
                                <!-- <button type="button" data-action>Annuler</button> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
           </div>
        </section>
    </main>

    <?php include 'includes/admin-sidebar.php'; ?>

</body>
</html>
