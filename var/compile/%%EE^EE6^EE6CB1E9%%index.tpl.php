<?php /* Smarty version 2.6.31, created on 2021-07-14 12:58:18
         compiled from import/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'import/index.tpl', 11, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('h1' => "Импорт товаров")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p>
<h3>Загрузка файла импорта</h3>
<form method="post" action="/import/upload" class="form f400p" enctype="multipart/form-data">
    <div class="form-group">
        <label for="">Файл импорта:</label>
        <input class="form-control" multiple type="file" name="import_file">
    </div>
    <div class="form-element">
        <button class="btn btn-default"><?php echo ((is_array($_tmp=@$this->_tpl_vars['submit_name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Импортировать') : smarty_modifier_default($_tmp, 'Импортировать')); ?>
</button>
    </div>
</form>
</p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>