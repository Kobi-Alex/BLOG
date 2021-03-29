<h2 class="text-center text-secondary pt-4 mt-4">ADMIN CONTROL COMMENTS</h2>

<div class="row m-0 p-0">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        
        <h5 class="d-flex justify-content-left w-75 px-3 pt-3 pb-1">All comments: <?=count($comments)?></h5>  
         
        <div class="rounded px-4 py-2 shadow-sm w-75" style="background-color: #CFDEF3">
            <?php
                foreach ($comments as $comment) {
            ?>
                <div class="mt-3 mb-1 pl-2 py-1 text-white rounded shadow d-flex justify-content-between" style="font-size:14px; background-color: #4dd5ed">
                    <div>
                        Status: 
                        <?php
                            if ($comment->status == 'delete') {
                        ?>
                            <span class="text-danger"><?=$comment->status?></span>
                        <?php
                            } else if ($comment->status == 'not approved') {
                        ?>
                            <span class="text-primary"><?=$comment->status?></span>
                        <?php
                            } else {
                        ?>
                            <span class="text-dark"><?=$comment->status?></span>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="m-0 pr-3">
                        <a class="dropdown-toggle m-0 p-0 text-white" href="/admin/index" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            change status
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"href="/comment/changeStatus?id=<?=$comment->id?>&status=approved&type=0">approved</a>
                            <a class="dropdown-item"href="/comment/changeStatus?id=<?=$comment->id?>&status=not approved&type=0">not approved</a>
                            <a class="dropdown-item"href="/comment/changeStatus?id=<?=$comment->id?>&status=delete&type=0">delete</a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between text-primary pt-3" style="font-size:14px">
                    <p>Author: <?=$folloverNicks[$comment->id]?></p>
                    <p class="text-info">Date: <?=date('Y-m-d', strtotime($comment->date))?></p>
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