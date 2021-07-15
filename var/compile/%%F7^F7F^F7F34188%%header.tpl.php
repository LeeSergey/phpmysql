<?php /* Smarty version 2.6.31, created on 2021-07-14 12:50:56
         compiled from header.tpl */ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Каталог товаров</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container site-wrapper">
    <header>
        <div class="row">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/products/list" class="nav-link">Товары</a></li>
                <li class="nav-item"><a href="/categories/list" class="nav-link">Категории</a></li>
                <li class="nav-item"><a href="/import/index" class="nav-link">Импорт товаров</a></li>
            </ul>
        </div>
    </header>
    

    <div class="row">
        <div class="col-md-3">
            <nav class="nav flex-column nav-pills">
                <?php $_from = $this->_tpl_vars['categories_shared']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category']):
?>
                    <a href="/categories/view?id=<?php echo $this->_tpl_vars['category']['id']; ?>
" class="nav-link <?php if ($this->_tpl_vars['current_category']['id'] == $this->_tpl_vars['category']['id']): ?> active<?php endif; ?>"><?php echo $this->_tpl_vars['category']['name']; ?>
</a>
                <?php endforeach; endif; unset($_from); ?>
            </nav>
        </div>
        <div class="col-md-9">
            <?php if ($this->_tpl_vars['h1']): ?><h1><?php echo $this->_tpl_vars['h1']; ?>
</h1><?php endif; ?>