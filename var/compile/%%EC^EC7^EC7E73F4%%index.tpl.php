<?php /* Smarty version 2.6.31, created on 2021-07-05 14:27:16
         compiled from categories/index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('h1' => "Список категорий")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <p><a href='/categories/add'>Добавить</a></p>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название Категории</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category']):
?>
                <tr>
                    <td><?php echo $this->_tpl_vars['category']['id']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['category']['name']; ?>
</td>
                    <td>
                        <a href="/categories/edit?id=<?php echo $this->_tpl_vars['category']['id']; ?>
" class="btn btn-primary">Ред</a>
                        !
                        <form action="/categories/delete" method="POST" style="display: inline;"><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['category']['id']; ?>
"><input type="submit" value="Уд" class="btn btn-danger"></form>
                    </td>
                </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>