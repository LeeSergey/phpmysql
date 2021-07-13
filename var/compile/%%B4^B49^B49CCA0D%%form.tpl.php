<?php /* Smarty version 2.6.31, created on 2021-07-13 15:28:41
         compiled from products/form.tpl */ ?>
<form action="" method="POST" class="form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
">
    <div class="form-element">
        <label for="">
            Название товара:<br>
            <input type="text" name="name" value="<?php echo $this->_tpl_vars['product']['name']; ?>
" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Категория товара:<br>
            <select name="category_id" >
                <?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category']):
?>
                    <option <?php if ($this->_tpl_vars['category']['id'] == $this->_tpl_vars['product']['category_id']): ?> selected="selected" <?php endif; ?> value="<?php echo $this->_tpl_vars['category']['id']; ?>
"><?php echo $this->_tpl_vars['category']['name']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Артикул:<br>
            <input type="text" name="article" value="<?php echo $this->_tpl_vars['product']['article']; ?>
" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Фото:<br>
            <input type="file" multiple name="images[]" >
        </label>
        <?php if ($this->_tpl_vars['product']['images']): ?>
            <div class="form-group d-flex flex-wrap">
                <?php $_from = $this->_tpl_vars['product']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['image']):
?>
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary sm" data-image-id="<?php echo $this->_tpl_vars['image']['id']; ?>
" onclick="return deleteImage(this);">Удалить</button>
                        </div>
                        <img src="<?php echo $this->_tpl_vars['image']['path']; ?>
" alt="<?php echo $this->_tpl_vars['image']['name']; ?>
" width="100">

                    </div>
                <?php endforeach; endif; unset($_from); ?>
            </div>
            <script>
                <?php echo '

                    function deleteImage(button){
                        let imageId =  $(button).attr(\'data-image-id\');
                        imageId = parseInt(imageId);

                        if (!imageId){
                            alert(\'Проблема с image_id\');
                            return false;
                        }

                        let url = \'/products/delete_image\';
                        const formData = new FormData();
                        formData.append(\'product_image_id\' , imageId);

                        fetch(url, {

                            method: \'POST\',
                            body : formData,

                        })
                        .then((response) => {
                            response.text()
                            .then((text) => {
                               if(text.indexOf(\'error\') > -1) {
                                   alert(\'Ошибка при удалении\');
                               } else {
                                   document.location.reload();
                               }
                            });
                        });

                        return false;

                    }

                '; ?>

            </script>
        <?php endif; ?>
    </div>
    <div class="form-element">
        <label for="">
            Цена:<br>
            <input type="number" name="price" value="<?php echo $this->_tpl_vars['product']['price']; ?>
" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Количество товара на складе:<br>
            <input type="number" name="amount" value="<?php echo $this->_tpl_vars['product']['amount']; ?>
" required>
        </label>
    </div>
    <div class="form-element">
        <label for="">
            Описание товара:<br>
            <textarea name="description" required><?php echo $this->_tpl_vars['product']['description']; ?>
</textarea>
        </label>
    </div>
    <div class="form-element">
        <input type="submit" value="<?php echo $this->_tpl_vars['submit_name']; ?>
" class="btn btn-default">
    </div>
</form>