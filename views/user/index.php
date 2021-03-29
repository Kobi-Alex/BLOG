<h2 class="text-center text-secondary pt-4 mt-4">ADMIN CONTROL USERS</h2>
<div class="row m-0 p-0 pt-4">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        <?php
            foreach ($users as $user) {
        ?>
            <div class="rounded px-3 shadow-sm w-75 mb-3" style="background-color: #EAEAEA">
                <div class="mt-3 mb-1 pl-2 py-1 bg-warning text-white rounded shadow" style="font-size:15px">
                   <div class="d-flex justify-content-between">
                        <div>
                            Role: 
                            <?php
                                if ($user->role == 'author') {
                            ?>
                                <span class="text-primary"><?=$user->role?></span>
                            <?php
                                } else if ($user->role == 'follower') {
                            ?>
                                <span class="text-success"><?=$user->role?></span>
                            <?php
                                } else {
                            ?>
                                <span class="text-danger"><?=$user->role?></span>
                            <?php
                                }
                            ?>
                        </div>
                        
                        <div class="m-0 pr-3">
                            <a class="nav-link dropdown-toggle m-0 p-0" href="blog/index" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                change role
                            </a>
                            <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/admin/changeRoleUser?id=<?=$user->id?>&role=administrator">Administrator</a>
                                <a class="dropdown-item" href="/admin/changeRoleUser?id=<?=$user->id?>&role=author">Author</a>
                                <a class="dropdown-item"href="/admin/changeRoleUser?id=<?=$user->id?>&role=follower">Follower</a>
                            </div>
                        </div>
                   </div>
                    
                </div>
                <hr class="m-0 pb-4 mt-2">
                <div class="d-flex">
                    <div class="pb-4 pr-4" style="font-size:20px">
                        <img class="rounded" src="/<?=$user->url_avatar?>" alt="" width="85" height="85">  
                    </div>
                    <div class="px-4 pt-2" style="font-size:14px">
                        <p>Nick name: <span class="text-info"><?=$user->nick?></span></p>
                        <p>E-mail: <span class="text-info"><?=$user->email?></span></p>
                    </div>  
                </div>
                <hr class="m-0 pb-4">
                <div class="d-flex flex-column m-0">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-danger btn-sm w-25 mb-3" href="/admin/deleteUser?id=<?=$user->id?>" role="button">Delete user</a> 
                    </div>
                </div>
            </div>
        <?php 
            }
        ?>
    </div>
</div>