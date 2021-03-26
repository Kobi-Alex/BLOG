<h1>CREATE TEXT</h1>

<form method="POST">
    <div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" value="<?=$model->text?>" name="text"></textarea>
        </div>

        <button type="submit" class="btn btn-success btn-sm w-25 mb-2">CREATE</button>
        <a class="btn btn-outline-primary btn-sm w-25 mb-4" href="/blog" role="button">CANCEL</a> 
    </div>
</form>