<h2 class="text-center pt-4">Current author post</h2>

<div class="row m-0 p-0 pt-2">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        <div class="rounded px-3 shadow-sm w-75 mb-3" style="background-color: #DBDBDB">
            <div class="d-flex justify-content-between text-secondary pt-3" style="font-size:14px">
                <p>Status: <span style="color: #c31432"><?=$record->status?></span></p>
                <p>Date: <?= date('F jS, Y', strtotime($record->date))?> </p>
            </div>  
            <hr class="m-0 pb-4">
            <div style="font-size:20px">
                <span><?=$record->text?></span>
            </div>
            <div class="pt-4 pb-2 d-flex justify-content-between">
                <div>
                    <a class="btn like disabled" style="font-size:17px" role="button" value ="<?=$record->id?>">
                        <i class="far fa-thumbs-up" style="color:#7303c0"></i>
                        <span><?=$record->like?></span>
                    </a>
                    <a class="btn dislike disabled" style="font-size:17px" role="button" value ="<?=$record->id?>">
                        <i class="far fa-thumbs-down" style="color:#FF0000"></i>
                        <span><?=$record->dislike?></span>
                    </a>
                </div>
                <div class=" d-flex justify-content-end w-50">
                    <?php
                        if ($record->status == 'not approved') {
                    ?>
                        <a class="btn btn-info btn-sm w-50 mb-2 " href="/blog/itemEdit?id=<?=$record->id?>" role="button">Edit</a>
                    <?php 
                        }
                    ?>
                </div>
            </div>
        </div>

        <h5 class="d-flex justify-content-left w-75 px-3 pt-3 pb-1">All comments: <?=count($comments)?></h5> 

        <div class="rounded px-4 py-2 shadow-sm w-75" style="background-color: #CFDEF3">
            <?php
                foreach ($comments as $comment) {
            ?>
                <div class="d-flex justify-content-between pt-3" style="font-size:14px">
                   
                    <?php
                        if ($comment->status == 'not approved') {
                    ?>
                        <p class="text-warning"><?=$comment->status?></p>
                    <?php
                        } else if ($comment->status == 'delete') {
                    ?>
                        <p class="text-danger"><?=$comment->status?></p>
                    <?php
                        } else {
                    ?>
                        <p class="text-success"><?=$comment->status?></p>
                    <?php
                        }
                    ?>
                    <p class="text-info"><?=date('Y-m-d', strtotime($comment->date))?></p>
                </div>
                <div>
                    <span><?=$comment->text?></span>
                </div>
                <div class="d-flex justify-content-end">
                    <a class="btn like-comment px-2 disabled" style="font-size:14px" role="button" value ="<?=$comment->id?>">
                        <i class="far fa-thumbs-up" style="color:#3d72b4"></i>
                        <span><?=$comment->like?></span>
                    </a>
                    <a class="btn dislike-comment px-2 disabled" style="font-size:14px" role="button" value ="<?=$comment->id?>">
                        <i class="far fa-thumbs-down" style="color:#00223E"></i>
                        <span><?=$comment->dislike?></span>
                    </a>
                </div>
                <hr class="my-1">
            <?php 
                }
            ?>
        </div>
    </div>
</div>