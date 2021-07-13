<?php /* Smarty version 2.6.31, created on 2021-07-12 17:41:05
         compiled from products/index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('h1' => "Список товаров")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <p><a href='/products/add'>Добавить</a></p>
        <nav>
            <ul class="pagination">
                <?php unset($this->_sections['pagination']);
$this->_sections['pagination']['loop'] = is_array($_loop=$this->_tpl_vars['pages_count']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pagination']['name'] = 'pagination';
$this->_sections['pagination']['show'] = true;
$this->_sections['pagination']['max'] = $this->_sections['pagination']['loop'];
$this->_sections['pagination']['step'] = 1;
$this->_sections['pagination']['start'] = $this->_sections['pagination']['step'] > 0 ? 0 : $this->_sections['pagination']['loop']-1;
if ($this->_sections['pagination']['show']) {
    $this->_sections['pagination']['total'] = $this->_sections['pagination']['loop'];
    if ($this->_sections['pagination']['total'] == 0)
        $this->_sections['pagination']['show'] = false;
} else
    $this->_sections['pagination']['total'] = 0;
if ($this->_sections['pagination']['show']):

            for ($this->_sections['pagination']['index'] = $this->_sections['pagination']['start'], $this->_sections['pagination']['iteration'] = 1;
                 $this->_sections['pagination']['iteration'] <= $this->_sections['pagination']['total'];
                 $this->_sections['pagination']['index'] += $this->_sections['pagination']['step'], $this->_sections['pagination']['iteration']++):
$this->_sections['pagination']['rownum'] = $this->_sections['pagination']['iteration'];
$this->_sections['pagination']['index_prev'] = $this->_sections['pagination']['index'] - $this->_sections['pagination']['step'];
$this->_sections['pagination']['index_next'] = $this->_sections['pagination']['index'] + $this->_sections['pagination']['step'];
$this->_sections['pagination']['first']      = ($this->_sections['pagination']['iteration'] == 1);
$this->_sections['pagination']['last']       = ($this->_sections['pagination']['iteration'] == $this->_sections['pagination']['total']);
?>
                    <li class="page-item <?php if ($_GET['p'] == $this->_sections['pagination']['iteration']): ?>active<?php endif; ?>"><a href="<?php echo $_SERVER['PATH_INFO']; ?>
?p=<?php echo $this->_sections['pagination']['iteration']; ?>
" class="page-link"><?php echo $this->_sections['pagination']['iteration']; ?>
</a></li>
                <?php endfor; endif; ?>
            </ul>
        </nav>
        <p>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Название товара</th>
                        <th>Категория</th>
                        <th>Артикул</th>
                        <th>Цена</th>
                        <th>Количество на складе</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
                    <tr>
                        <td><?php echo $this->_tpl_vars['product']['id']; ?>
</td>
                        <td width="200">
                            <strong><?php echo $this->_tpl_vars['product']['name']; ?>
</strong>
                            <?php if ($this->_tpl_vars['product']['images']): ?>
                                <br>
                                <?php $_from = $this->_tpl_vars['product']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['image']):
?>
                                    <img width="40" src="<?php echo $this->_tpl_vars['image']['path']; ?>
" alt="<?php echo $this->_tpl_vars['image']['name']; ?>
">
                                <?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $this->_tpl_vars['product']['category_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['product']['article']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['product']['price']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['product']['amount']; ?>
</td>
                        
                        <td>
                            <a href="/products/edit?id=<?php echo $this->_tpl_vars['product']['id']; ?>
" class="btn btn-primary">Ред</a>
                            !
                            <form action="/products/delete" method="POST" style="display: inline;"><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
"><input type="submit" value="Уд" class="btn btn-danger"></form>
                        </td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </tbody>
            </table>
        </p>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>