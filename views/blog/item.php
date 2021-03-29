<h2 class="text-center pt-4">POST</h2>

<div class="row m-0 p-0">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        <div class="bg-light rounded px-3 shadow-sm w-75 mb-4"> 

            <div class="d-flex justify-content-between text-secondary pt-3" style="font-size:14px">
                <p>Author: <?=$_GET['author']?></p>
                <p>Data: <?=date('F jS, Y', strtotime($record->date))?></p>
            </div>  
            <hr class="m-0 pb-4">
            <div style="font-size:20px">
                <span><?=$record->text?></span>
            </div>
            <div class="pt-4 pb-2 d-flex justify-content-between ">
                <div>
                    <a class="btn like" style="font-size:17px" role="button" value ="<?=$record->id?>">
                        <i class="far fa-thumbs-up" style="color:#7303c0"></i>
                        <span class="like-count<?=$record->id?>"><?=$record->like?></span>
                    </a>
                    <a class="btn dislike" style="font-size:17px" role="button" value ="<?=$record->id?>">
                        <i class="far fa-thumbs-down" style="color:#FF0000"></i>
                        <span class="dislike-count<?=$record->id?>"><?=$record->dislike?></span>
                    </a>
                </div>
            </div>
            <div class="d-flex justify-content-end m-0">
                <?php
                    if (isset($_SESSION['auth'])) {
                ?>
                    <a class="btn btn-secondary btn-sm w-25 mb-4" href="/comment/comment?id=<?=$_GET['id']?>&author=<?=$_GET['author']?>" role="button">Add comment</a> 
                <?php
                    }
                ?> 
            </div>

        </div>

        <h5 class="d-flex justify-content-left w-75 px-3 pt-3 pb-1">All comments: <?=count($comments)?></h5>  
         
        <div class="rounded px-4 py-2 shadow-sm w-75" style="background-color: #CFDEF3">
            <?php
                foreach ($comments as $comment) {
            ?>
                <div class="d-flex justify-content-between text-primary pt-3" style="font-size:14px">
                    <p><?=$folloverNicks[$comment->id]?></p>
                    <p class="text-info"><?=date('Y-m-d', strtotime($comment->date))?></p>
                </div>
                <div class="" >
                    <span><?=$comment->text?></span>
                </div>
                <div class="d-flex justify-content-end">
                    <a class="btn like-comment px-2" style="font-size:14px" role="button" value ="<?=$comment->id?>">
                        <i class="far fa-thumbs-up" style="color:#3d72b4"></i>
                        <span class="like-comment-count<?=$comment->id?>"><?=$comment->like?></span>
                    </a>
                    <a class="btn dislike-comment px-2" style="font-size:14px" role="button" value ="<?=$comment->id?>">
                        <i class="far fa-thumbs-down" style="color:#00223E"></i>
                        <span class="dislike-comment-count<?=$comment->id?>"><?=$comment->dislike?></span>
                    </a>
                </div>
                <hr class="my-1">
            <?php 
                }
            ?>
            
        </div>
    </div>
</div>

<script>
    $('.like').click(function(){
        let id = $(this).attr('value');
        actionUpdateLikeDislike(id, 'like');
    });

    $('.dislike').click(function(){
        let id = $(this).attr('value');
        actionUpdateLikeDislike(id, 'dislike');
    });

    function actionUpdateLikeDislike(id, type) {

        var host = window.location.protocol + '//' + window.location.host;
        $.post(host + "/blog/LikeDislikeRecord", {
            id: id,
            type: type

        }, function(data) {

            response = JSON.parse(data);
            console.log(data);

            if (response.status = 'success') {
                $('.' + type + '-count' + response.id).html(response.type);
            } else {
                alert("ERROR");
            }
        });
    }
</script>

<script>
    $('.like-comment').click(function() {
        let id = $(this).attr('value');
        // alert(id);
        actionUpdateCommentLikeDislike(id, 'like');
    });
    $('.dislike-comment').click(function() {
        let id = $(this).attr('value');
        actionUpdateCommentLikeDislike(id, 'dislike');
    });

    function actionUpdateCommentLikeDislike(id, type)
    {
        var host = window.location.protocol + '//' + window.location.host;
        $.post(host + "/comment/CommentLikeDislikeRecord", {
            id: id,
            type: type

        }, function(data) {
            console.log(data);
            response = JSON.parse(data);
            if (response.status = 'success') {
                $('.' + type + '-comment-count' + response.id).html(response.type);
            } else {
                alert('ERROR');
            }
        })
    }
</script>