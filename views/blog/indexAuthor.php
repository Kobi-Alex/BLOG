
<h2 class="text-center pt-4">My records</h2>

<div class="row m-0 p-0 pt-4">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        <?php
            foreach ($blogs as $blog) {
                $formatted_date = date('F jS, Y', strtotime($blog->date));
        ?>
            <div class="rounded px-3 shadow-sm w-75 mb-3" style="background-color: #DBDBDB">
                <div class="d-flex justify-content-between text-secondary pt-3" style="font-size:14px">
                    <p>Status: <span style="color: #c31432"><?=$blog->status?></span></p>
                    <p>Date: <?=$formatted_date?> </p>
                </div>  
                <hr class="m-0 pb-4">
                <div style="font-size:20px">
                    <span><?=$blog->text?></span>
                </div>
                <div class="pt-4 d-flex justify-content-between ">
                    <div>
                        <a class="btn like disabled" style="font-size:17px" role="button" value ="<?=$blog->id?>">
                            <i class="far fa-thumbs-up" style="color:#7303c0"></i>
                            <span class="like-count<?=$blog->id?>"><?=$blog->like?></span>
                        </a>
                        <a class="btn dislike disabled" style="font-size:17px" role="button" value ="<?=$blog->id?>">
                            <i class="far fa-thumbs-down" style="color:#FF0000"></i>
                            <span class="dislike-count<?=$blog->id?>"><?=$blog->dislike?></span>
                        </a>
                    </div>
                    <div>
                        Comments: <?=$comentsCount[$blog->id]?>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end m-0">
                    <?php
                        if ($blog->status == 'delete') {
                    ?>
                        <a class="btn btn-info btn-sm w-25 mb-3 mx-2" href="/blog/UpdateItem?id=<?=$blog->id?>" role="button">Update</a>
                    <?php 
                        }
                    ?>
                    <a class="btn btn-warning btn-sm w-25 mb-3 " href="/blog/itemAuthor?id=<?=$blog->id?>" role="button">Review</a> 
                </div>
            </div>
        <?php 
            }
        ?>
    </div>
</div>