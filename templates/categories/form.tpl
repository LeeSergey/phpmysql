<form action="" method="POST" class="form">
    <input type="hidden" name="id" value="{$category.id}">
    <div class="form-element">
        <label for="">
            Название категории:<br>
            <input type="text" name="name" value="{$category.name}" required>
        </label>
    </div>
    <div class="form-element">
        <input type="submit" value="{$submit_name}" class="btn btn-default">
    </div>
</form>