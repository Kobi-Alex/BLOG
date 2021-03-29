<div class="bg-success position-fixed w-100" style="height:100%">
    <form method="POST" enctype="multipart/form-data">  
        <div class="d-flex flex-column align-items-center">
            
            <div class="my-4">
            <?php
                if(!isset($_SESSION)) {
            ?>
                <img id="photo" class="mb-2 mt-2 rounded-circle" src="/<?=$model->url_avatar?>" alt="" width="72" height="72">
            <?php
                } else {
            ?>
                <img id="photo" class="mb-2 mt-2 rounded-circle" src="/avatar/avatar2.png" alt="" width="72" height="72">
            <?php
                }
            ?>
            </div>     
    
            <div class="form-group w-25 my-0">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?=$model->email?>" name="email">
                <small id="emailHelp" class="form-text text-muted"> We'll never share your email with anyone else.</small>
            </div>
    
            <div class="form-group row w-25">
                <label for="inputPassword" class="col-form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword" value="<?=$model->password?>" name="password">
            </div>
    
            <input class="form-control w-25 my-2" type="text" placeholder= "Default input" value="<?=$model->nick?>" name="nick"></input>

            <div class="input-group input-group-sm mb-1 w-25" >

                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" aria-describedby="inputGroupFileAddon03" name="avatar">
                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-warning btn-sm w-25 mb-2">SIGN UP</button>
            <a class="btn btn-outline-primary btn-sm w-25 mb-4" href="/blog" role="button">CANCEL</a>
        </div>
    </form>
</div>


<script>
    $('#file').change(function(){
        var file = document.getElementById('file').files;
        if(file.length == null) document.getElementById('photo').setAttribute("src", "/avatar/avatar2.png");

        if(file.length > 0) {
            var file_reader = new FileReader();
            file_reader.onload = function(){
                document.getElementById('photo').setAttribute("src", event.target.result);
            };
        }
        file_reader.readAsDataURL(file[0]);
    });
</script>