
<h2 class="text-center text-secondary pt-4">ADMIN CONTROL RECORDS</h2>
<div class="row m-0 p-0 pt-4">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        <?php
            foreach ($blogs as $blog) {
                $formatted_date = date('F jS, Y', strtotime($blog->date));
        ?>
            <div class="rounded px-3 shadow-sm w-75 mb-3" style="background-color: #EAEAEA">
                <div class="mt-3 mb-1 pl-2 py-1 bg-warning text-white rounded shadow" style="font-size:15px">
                   <div class="d-flex justify-content-between">
                        <div>
                            Status: 
                            <?php
                                if ($blog->status == 'delete') {
                            ?>
                                <span class="text-danger"><?=$blog->status?></span>
                            <?php
                                } else if ($blog->status == 'not approved') {
                            ?>
                                <span class="text-primary"><?=$blog->status?></span>
                            <?php
                                } else {
                            ?>
                                <span class="text-secondary"><?=$blog->status?></span>
                            <?php
                                }
                            ?>
                        </div>
                        
                        <div class="m-0 pr-3">
                            <a class="nav-link dropdown-toggle m-0 p-0" href="blog/index" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                change status
                            </a>
                            <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/admin/changeStatus?id=<?=$blog->id?>&status=approved">approved</a>
                                <a class="dropdown-item" href="/admin/changeStatus?id=<?=$blog->id?>&status=not approved">not approved</a>
                                <a class="dropdown-item"href="/admin/changeStatus?id=<?=$blog->id?>&status=delete">delete</a>
                            </div>
                        </div>
                   </div>
                    
                </div>
                <div class="d-flex justify-content-between text-secondary pt-2" style="font-size:14px">
                    <p class="">Author: <?=$authorNicks[$blog->id]?></p>
                    <p class="">Date: <?=$formatted_date?> </p>
                </div>  
                <hr class="m-0 pb-4">
                <div style="font-size:20px">
                    <span><?=$blog->text?></span>
                </div>
                <div class="pt-4 d-flex justify-content-between ">
                    <div>
                        <a class="btn like disabled" style="font-size:17px" role="button" value ="<?=$blog->id?>">
                            <i class="far fa-thumbs-up" style="color:#7303c0"></i>
                            <span><?=$blog->like?></span>
                        </a>
                        <a class="btn dislike disabled" style="font-size:17px" role="button" value ="<?=$blog->id?>">
                            <i class="far fa-thumbs-down" style="color:#FF0000"></i>
                            <span><?=$blog->dislike?></span>
                        </a>
                    </div>
                    <div>
                        Comments: <?=$comentsCount[$blog->id]?>
                    </div>
                </div>
                <div class="d-flex flex-column m-0">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-success btn-sm w-25 mb-3" href="/admin/item?id=<?=$blog->id?>&author=<?=$authorNicks[$blog->id]?>" role="button">Review comments</a> 
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-danger btn-sm w-25 mb-3" href="/admin/deleteRecords?id=<?=$blog->id?>" role="button">Delete record</a> 
                    </div>
                </div>
            </div>
        <?php 
            }
        ?>
    </div>
</div>