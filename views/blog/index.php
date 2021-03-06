
<div class="row m-0 p-0 pt-4">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        <?php
            foreach ($blogs as $blog) {
                $formatted_date = date('F jS, Y', strtotime($blog->date));
        ?>
            <div class="bg-light rounded px-3 shadow-sm w-75 mb-3">
                <div class="d-flex justify-content-between text-secondary pt-3" style="font-size:14px">
                    <p>Author: <?=$authorNicks[$blog->id]?></p>
                    <p>Date: <?=$formatted_date?> </p>
                </div>  
                <hr class="m-0 pb-4">
                <div style="font-size:20px">
                    <span><?=$blog->text?></span>
                </div>
                <div class="pt-4 d-flex justify-content-between ">
                    <div>
                        <a class="btn like" style="font-size:17px" role="button" value ="<?=$blog->id?>">
                            <i class="far fa-thumbs-up" style="color:#7303c0"></i>
                            <span class="like-count<?=$blog->id?>"><?=$blog->like?></span>
                        </a>
                        <a class="btn dislike" style="font-size:17px" role="button" value ="<?=$blog->id?>">
                            <i class="far fa-thumbs-down" style="color:#FF0000"></i>
                            <span class="dislike-count<?=$blog->id?>"><?=$blog->dislike?></span>
                        </a>
                    </div>
                    <div>
                        Comments: <?=$comentsCount[$blog->id]?>
                    </div>
                </div>
                <div class="d-flex justify-content-end m-0">
                    <a class="btn btn-primary btn-sm w-25 mb-3" href="/blog/item?id=<?=$blog->id?>&author=<?=$authorNicks[$blog->id]?>" role="button">Review</a> 
                </div>
            </div>
        <?php 
            }
        ?>
    </div>
</div>

<script>

    $('.like').click(function(){
        let id = $(this).attr('value');
        actionData(id, 'like');
    });

    $('.dislike').click(function(){
        let id = $(this).attr('value');
        actionData(id, 'dislike');
    });

    function actionData(id, type)
    {
        let host = window.location.protocol + "//" + window.location.host;
        $.post(host + "/blog/LikeDislikeRecord", {
            id: id,
            type: type

        }, function(data){
            response = JSON.parse(data);
            console.log(data);

            if (response.status == 'success') {
                $("." + type + "-count" + response.id).html(response.type);
            } else {
                alert("ERROR");
            }
        });
    }

</script>