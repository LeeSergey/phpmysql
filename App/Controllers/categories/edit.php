<?php

use App\Category;
use App\Request;
use App\Response;

$id = Request::getIntFromGet('id',false);
$category = [];

if ($id) {
    $category = Category::getById($id);
}

if (Request::isPost()){

    $id = $_POST['id'];

    $category = Category::getDataFromPost();

    $edited = Category::updateById($id, $category);

    if ($edited) {
        Response::redirect('/categories/list');
    } else {
        die("some edit error");
    }

}
$smarty->assign('category',$category);
$smarty->display('categories/edit.tpl');

/**
 * 1. Проверять был ли отправлен POST запрос на эту страницу
 * 2. Полученные данные записывать в базу данных
 * 3. Делать редирект на главную страницу
 */

?>