<?php
$page = 'edit';

require_once "includes/session.php";
require_once "includes/database.php";

// Check if image file is a actual image or fake image
if (! empty($_FILES)) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["thumbnail"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["thumbnail"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

if (isset($_GET['p'])) {
    $post_id = $_GET['p'];

    $query = "SELECT p.*, u.username AS author, c.id AS categorie_id, c.name AS categorie_name
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

        $stmt->bindValue(':id', $post_id);

        $stmt->execute();

        header('Location: listing.php');
        exit;
    }
}

$query = "SELECT u.*
FROM users u";

$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll();

$query = "SELECT c.*
FROM categories c";

$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll();

// UPDATE si on met à jour un post existant
if (! empty($_POST) && ! empty($_GET['p'])) {
    $post_id = $_GET['p'];

    $title = htmlentities(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $content = htmlentities(trim($_POST['content']), ENT_QUOTES, 'UTF-8');
    $excerpt = htmlentities(trim($_POST['content']), ENT_QUOTES, 'UTF-8');
    $status = htmlentities(trim($_POST['status']), ENT_QUOTES, 'UTF-8');
    $thumbnail = htmlentities(basename($_FILES["thumbnail"]["name"]), ENT_QUOTES, 'UTF-8');
    $user_id = htmlentities($_POST['author'], ENT_QUOTES, 'UTF-8');
    $categorie_id = htmlentities($_POST['categorie'], ENT_QUOTES, 'UTF-8');

    $sql = "UPDATE posts p
    LEFT JOIN categories_posts cp ON p.id = cp.post_id
    SET title = :title, content = :content, excerpt = :excerpt, status = :status, thumbnail = :thumbnail, user_id = :user_id, categorie_id = :categorie_id
    WHERE id = :post_id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':excerpt', $excerpt);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':thumbnail', $thumbnail);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':post_id', $post_id);
    $stmt->bindValue(':categorie_id', $categorie_id);

    $stmt->execute();
    // header("Location: /admin/edit.php?p=" . $post_id);
    // exit();
}

// INSERT INTO si on publie un nouveau post
if (! empty($_POST) && empty($_GET['p'])) {
    $title = htmlentities(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $content = htmlentities(trim($_POST['content']), ENT_QUOTES, 'UTF-8');
    $excerpt = htmlentities(trim($_POST['excerpt']), ENT_QUOTES, 'UTF-8');
    $status = htmlentities(trim($_POST['status']), ENT_QUOTES, 'UTF-8');
    $thumbnail = htmlentities(trim($_POST['thumbnail']), ENT_QUOTES, 'UTF-8');
    $user_id = serialize($_POST['user_id']);

    $sql = "INSERT INTO posts (title, content, excerpt, status, thumbnail, user_id)
        VALUES (:title, :content, :excerpt, :status, :thumbnail, :user_id)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':excerpt', $excerpt);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':thumbnail', $thumbnail);
    $stmt->bindValue(':user_id', $user_id);

    $stmt->execute();
    $new_id = $pdo->lastInsertId();
    header("Location: /admin/edit.php?p=" . $new_id);
    exit();
}

?>

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
                        <input id="thumbnail" class="form-control" type="file" name="thumbnail" id="thumbnail">
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
