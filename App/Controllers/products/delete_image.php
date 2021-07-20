<?php

use App\ProductImage;
use App\Request;

$productImageId = Request::getIntFromPost('product_image_id',false);

if (!$productImageId){
    die("error with id");
}

$deleted = ProductImage::deleteById($productImageId);

/*if ($deleted) {
    Response::redirect('/products/list');
} else {
    die("some error with delete");
}*/

/**
 * Нужно поле , по которому будет идентифицироваться удаляемая запись
 * Отправим запрос на удаление
 * Сделаем редирект на главную страницу
 */