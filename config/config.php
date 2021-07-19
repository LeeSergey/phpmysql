<?php

require_once __DIR__ . '/../libs/Smarty/Smarty.class.php';
//require_once __DIR__ . '/../App/Db.php';
//require_once __DIR__ . '/../App/DbExp.php';
//require_once __DIR__ . '/../App/Request.php';
//require_once __DIR__ . '/../App/Response.php';
//require_once __DIR__ . '/../App/Product.php';
//require_once __DIR__ . '/../App/ProductImage.php';
//require_once __DIR__ . '/../App/Category.php';
//require_once __DIR__ . '/../App/TasksQueue.php';
//require_once __DIR__ . '/../App/Import.php';

spl_autoload_register(function ($name){
    require_once __DIR__ . '/../App/' . $name . '.php';
});

define('APP_DIR', realpath(__DIR__ . '/../'));
define('APP_PUBLIC_DIR', APP_DIR . '/public');
define('APP_UPLOAD_DIR', APP_PUBLIC_DIR . '/upload');
define('APP_UPLOAD_PRODUCT_DIR', APP_UPLOAD_DIR . '/products');

if (!file_exists(APP_UPLOAD_DIR)){
    mkdir(APP_UPLOAD_DIR);
}

if (!file_exists(APP_UPLOAD_PRODUCT_DIR)){
    mkdir(APP_UPLOAD_PRODUCT_DIR);
}

$smarty = new Smarty(); // создание объекта смарти;
$smarty->template_dir = __DIR__ . '/../templates';
$smarty->compile_dir = __DIR__ . '/../var/compile';
$smarty->cache_dir = __DIR__ . '/../var/cache';
$smarty->config_dir = __DIR__ . '/../var/config';

function deleteDir($dir)
{
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? deleteDir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

