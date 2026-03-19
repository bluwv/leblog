<?php

$page = 'posts';

require_once "includes/session.php";
require_once "../config/database.php";
require_once '../controllers/post_controller.php';

// $total_posts = ceil($total / $limit);

// if ($page > $total_posts) {
//     header("Location: ?paged=" . $total_posts);
// }

require_once '../views/posts/list.php';
