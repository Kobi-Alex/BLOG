<h2 class="text-center pt-4">New comment</h2>

<form method="POST">
    <div class="w-100 d-flex flex-column align-items-center pt-4">
        <div class="bg-light rounded px-3 shadow-sm w-50 mb-4">
            <div class="d-flex justify-content-between text-secondary pt-3">
                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="add new comment" rows="3" value="<?=$model->text?>" name="text"></textarea>
            </div>

            <div class ='d-flex justify-content-around py-4'>
                <button type="submit" class="btn btn-success btn-sm w-25 mb-2">ADD</button>
                <a class="btn btn-danger btn-sm w-25 mb-2 pr-2" href="/blog/item?id=<?=$_GET['id']?>&author=<?=$_GET['author']?>" role="button">CANCEL</a> 
            </div>
        </div>
    </div>
</form>