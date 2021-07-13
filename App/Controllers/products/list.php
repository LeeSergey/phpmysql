<?php

$current_page = Request::getIntFromGet('p', 1);

$limit = 2;
$offset = ($current_page - 1) * $limit;

$products_count = Product::getListCount();
//
//$query = "SELECT COUNT(1) AS c FROM products AS p LEFT JOIN categories AS c ON p.category_id = c.id";
//
//$connect = mysqli_connect(static::$host, static::$username, static::$password, static::$database);
//
//if (mysqli_connect_errno()) {
//    $error = mysqli_connect_error();
//    var_dump($error);
//
//    exit;
//}$result = mysqli_query($connect, $query);
//
//if (mysqli_errno($connect)){
//return $result;
//    var_dump(mysqli_errno($connect));
//    exit;
//}
//
//$row = mysqli_fetch_row($result);
//
//$products_count = (string) ($row[0] ?? '');
//

$pages_count = ceil($products_count/$limit);

$products = Product::getList($limit, $offset);


$smarty->assign('pages_count', $pages_count);
$smarty->assign('products',$products);
$smarty->display('products/index.tpl');

