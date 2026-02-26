<div class="card">
    <a href="post.php">
        <div>
            <img src="assets/images/photo-1761839257961-4dce65b72d99.avif" width="600" height="400" alt="">
        </div>

        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
            </svg>

            <p class="data">
                <span><?php echo $post->author; ?></span>
                <span><?php echo date('d/m/Y', strtotime($post->created_at)); ?></span>
            </p>
            <h3 class="title"><?php echo $post->title; ?></h3>
            <!-- ! de virer les <p> sur les latests posts dans la col 2 -->
            <p><?php echo $post->content; ?></p>
        </div>
    </a>
</div>
