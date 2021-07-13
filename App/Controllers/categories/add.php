<?php

if (Request::isPost()){

    $category = Category::getDataFromPost();
    $inserted = Category::add($category);

    if ($inserted) {
        Response::redirect('/categories/list');
    } else {
        die("some insert error");
    }

}

$smarty->display('categories/add.tpl');
/**
 * 1. Проверять был ли отправлен POST запрос на эту страницу
 * 2. Полученные данные записывать в базу данных
 * 3. Делать редирект на главную страницу
 */

?>