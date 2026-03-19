<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head-admin.php'; ?>
    <title>Users</title>
</head>

<body class="edit d-flex flex-row-reverse">

    <main class="min-vh-100 vw-100">
        <header class="admin-header position-sticky d-flex align-items-center justify-content-between p-4">
            <h1>Liste des users</h1>
        </header>

        <section>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <th>
                                <?php echo $user->username; ?>
                            </th>
                            <td>
                                <?php echo $user->email; ?>
                            </td>
                            <td>
                                <?php echo $user->role; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>
    </main>

    <?php include 'includes/admin-sidebar.php'; ?>

    <script src="../source/js/script.js"></script>

</body>
</html>
