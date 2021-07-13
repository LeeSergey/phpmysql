<?php

$category_id = Request::getIntFromGet('id',false);

$category = Category::getById($category_id);
$products = Product::getListByCategory($category_id);
$smarty->assign('products',$products);
$smarty->assign('current_category',$category);
$smarty->display('categories/view.tpl');