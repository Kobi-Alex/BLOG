<h1>BLOGS</h1>
<div>
    <?php
        foreach ($blogs as $blog) {
    ?>
        <p>Date: <ins><?=$blog->date?></ins> </p>
        <p>Author: <?=$authorNicks[$blog->id]?></p>
        <hr>
        <p>text: <?=$blog->text?></p>
        <hr class="bg-secondary">
        <a class="btn btn-outline-primary btn-sm w-25 mb-4" href="/blog/item?id=<?=$blog->id?>&author=<?=$authorNicks[$blog->id]?>" role="button">View</a> 
    <?php 
        }
    ?>
</div>