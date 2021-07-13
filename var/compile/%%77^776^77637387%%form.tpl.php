<?php /* Smarty version 2.6.31, created on 2021-07-05 14:08:02
         compiled from categories/form.tpl */ ?>
<form action="" method="POST" class="form">
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['category']['id']; ?>
">
    <div class="form-element">
        <label for="">
            Название категории:<br>
            <input type="text" name="name" value="<?php echo $this->_tpl_vars['category']['name']; ?>
" required>
        </label>
    </div>
    <div class="form-element">
        <input type="submit" value="<?php echo $this->_tpl_vars['submit_name']; ?>
" class="btn btn-default">
    </div>
</form>