<form action="" method="POST" class="form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{$product.id}">
    <div class="form-element">
        <label for="">
            Название товара:<br>
            <input type="text" name="name" value="{$product.name}" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Категория товара:<br>
            <select name="category_id" >
                {foreach from=$categories item=category}
                    <option {if $category.id == $product.category_id} selected="selected" {/if} value="{$category.id}">{$category.name}</option>
                {/foreach}
            </select>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Артикул:<br>
            <input type="text" name="article" value="{$product.article}" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Фото:<br>
            <input type="file" multiple name="images[]" >
        </label>
        {if $product.images}
            <div class="form-group d-flex flex-wrap">
                {foreach from=$product.images item=image}
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary sm" data-image-id="{$image.id}" onclick="return deleteImage(this);">Удалить</button>
                        </div>
                        <img src="{$image.path}" alt="{$image.name}" width="100">

                    </div>
                {/foreach}
            </div>
            <script>
                {literal}

                    function deleteImage(button){
                        let imageId =  $(button).attr('data-image-id');
                        imageId = parseInt(imageId);

                        if (!imageId){
                            alert('Проблема с image_id');
                            return false;
                        }

                        let url = '/products/delete_image';
                        const formData = new FormData();
                        formData.append('product_image_id' , imageId);

                        fetch(url, {

                            method: 'POST',
                            body : formData,

                        })
                        .then((response) => {
                            response.text()
                            .then((text) => {
                               if(text.indexOf('error') > -1) {
                                   alert('Ошибка при удалении');
                               } else {
                                   document.location.reload();
                               }
                            });
                        });

                        return false;

                    }

                {/literal}
            </script>
        {/if}
    </div>
    <div class="form-element">
        <label for="">
            Цена:<br>
            <input type="number" name="price" value="{$product.price}" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Количество товара на складе:<br>
            <input type="number" name="amount" value="{$product.amount}" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Описание товара:<br>
            <textarea name="description" required>{$product.description}</textarea>
        </label>
    </div>
    <div class="form-element">
        <input type="submit" value="{$submit_name}" class="btn btn-default">
    </div>
</form>