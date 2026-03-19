<div class="card">
    <a href="post.php?p=<?php echo $post->id; ?>">
        <div>
            <img src="assets/images/photo-1761839257961-4dce65b72d99.avif" width="600" height="400" alt="">
        </div>

        <div>
            <p class="data">
                <span><?php echo $post->author; ?></span>
                <span><?php echo date('d/m/Y', strtotime($post->created_at)); ?></span>
            </p>
            <h3 class="title"><?php echo $post->title; ?></h3>
            <p><?php echo limit_words(htmlspecialchars_decode($post->content), 24); ?></p>
        </div>
    </a>
</div>
