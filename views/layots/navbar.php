
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0f9b1f">
    <a class="navbar-brand" href="/">
        <img class="" src="../assets/Image.svg" alt="" width="43" height="43">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/blog">RECORDS<span class="sr-only">(current)</span></a>
            </li>

            <?php 
                if (isset($user) && $user['role'] == 'author') {
            ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="blog/index" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            MY RECORDS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/blog/indexAuthor">My records</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/blog/create">Add new record</a>
                        </div>
                    </li>
            <?php
                }
                if (isset($user) && $user['role'] == 'administrator') {
            ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ADMINISTRATOR PANEL
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Records</a>
                            <a class="dropdown-item" href="#">Comments</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Users</a>
                        </div>
                </li>
            <?php
                }
            ?>
          </ul>
        <div>
            <?php
                if (isset($user)) {
                    // $user = json_decode($_SESSION['user'], true);
                    // if(isset($user) && $user['role'] == 'admin')
                    // if(isset($user) && $user['role'] == 'author')
            ?>
                <div class="dropdown">

                    <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle" src="/<?=$user['url_avatar']?>" alt="" width="43" height="43">
                        <span class="text-dark pl-2"><?=$user['email']?></span>
                    </a>

                    <div class="dropdown-menu text-center p-3 w-100 bg-light" aria-labelledby="dropdownMenu2">
                        <div class="pt-2">
                            <img class="rounded-circle" src="/<?=$user['url_avatar']?>" alt="" width="85" height="85">
                        </div>
                        <p><?=$user['nick']?></p>
                        <p><?=$user['email']?></p>
                        <hr>
                        <a class="btn btn btn-dark btn-sm w-100 mb-2" href="/user/edit?id=<?=$_SESSION['auth']?>">EDIT</a>
                        <a class="btn btn btn-dark btn-sm w-100" href="/user/logout">LOG OUT</a>
                    </div>
                </div>
                
            <?php 
                } else { 
            ?>
                <a class="btn btn btn-outline-warning btn-sm" href="/user/register" role="button">SignUp</a>
                <a class="btn btn btn-dark btn-sm" href="/user/login" role="button">SignIn</a>
            <?php 
                }
            ?>
        </div>
    </div>
</nav>
