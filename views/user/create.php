<div class="bg-success position-fixed w-100" style="height:100%">
    <form method="POST" enctype="multipart/form-data">  
        <div class="d-flex flex-column align-items-center">
            <div class="my-4">
                <img class="mb-2 mt-2" src="../assets/Image.svg" alt="" width="72" height="72">
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
    
            <div class="input-group input-group-sm mb-1 w-25">
                <!-- <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">Button</button>
                </div> -->
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03" name="avatar">
                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-warning btn-sm w-25 mb-2">SIGN UP</button>
            <a class="btn btn-outline-primary btn-sm w-25 mb-4" href="/blog" role="button">CANCEL</a>
        </div>
    </form>
</div>
