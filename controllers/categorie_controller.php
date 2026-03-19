<?php

require_once '../models/categorie_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'publish') {
        $name = $_POST['name'];

        createCategorie($pdo, $name);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['update'])) {
        $id = $_POST['update'];
        $name = $_POST['name'];

        updateCategorie($pdo, $id, $name);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['delete'];

        deleteCategorie($pdo, $id);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$categories = getCategories($pdo);
