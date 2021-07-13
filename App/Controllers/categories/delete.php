<?php

$id = Request::getIntFromPost('id',false);

if (!$id){
    die("Error with id");
}

$deleted = Category::deleteById($id);

if ($deleted) {
    Response::redirect('/categories/list');
} else {
    die("some error with delete");
}

/**
 * Нужно поле , по которому будет идентифицироваться удаляемая запись
 * Отправим запрос на удаление
 * Сделаем редирект на главную страницу
 */