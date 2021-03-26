<h1>VIEW</h1>

<div>

    <p>date: <?=$record->date?></p>
    <p>author: <?=$_GET['author']?></p>
    <hr class="bg-secondary">
    <p class="m-0 p-0"><?=$record->text?></p>
    <hr class="bg-secondary">
    <?php
        if (isset($_SESSION['auth'])) {
    ?>
        <a class="btn btn-outline-info btn-sm w-25 mb-4" href="/blog/comment?id=<?=$_GET['id']?>&author=<?=$_GET['author']?>" role="button">Add comment</a> 
    <?php
        }
    ?>

    <?php
        foreach ($comments as $comment) {
    ?>
        <div class="bg-muted w-75" >
            <p>Data: <?=$comment->date?></p>
            <p>Author: <?=$folloverNicks[$comment->id]?></p>
            <span><?=$comment->text?></span>
            <hr>
        </div>
    <?php 
        }
    ?>
</div>