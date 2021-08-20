<?php

use App\CategoryService;
use App\DI\Container;
use App\Kernel;
use App\Renderer;
use App\Router\Dispatcher;

require_once __DIR__ . '/../vendor/autoload.php';

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

//function deleteDir($dir)
//{
//    /**
//     * Системные ссылки существующие в любой директории в unix системах
//     */
//
////    $systemLinks = [
////        '.',
////        '..',
////    ];
//
//    /**
//     * Получаем список вложенных файлов и папок
//     */
//
////    $files = scandir($dir);
//
//    /**
//     * Срезаем системные ссылки
//     */
////    $files = array_diff($files, $systemLinks);
//
//
//    $files = array_diff(scandir($dir), ['.', '..']);
//
//    /**
//     * Итеративно обрабатваем все вложенные файлы и папки
//     */
//    foreach ($files as $file) {
//        /**
//         * Проверяем, если обрабатваем директорию , то рекурсивно удаляем ее и ее содержимое с помощью этой же функции
//         * если это файл , то просто удаляем.
//         */
//        (is_dir("$dir/$file")) ? deleteDir("$dir/$file") : unlink("$dir/$file");
//    }
//    return rmdir($dir);
//}

$di = new Container();

$di->singletone(Smarty::class, function (){
    $smarty = new Smarty(); // создание объекта смарти;
    $smarty->template_dir = APP_DIR . '/templates';
    $smarty->compile_dir = APP_DIR . '/var/compile';
    $smarty->cache_dir = APP_DIR . '/var/cache';
    $smarty->config_dir = APP_DIR . '/var/config';

    return $smarty;
});

$smarty = $di->get(Smarty::class);

$categoryService = new CategoryService();
$categories = $categoryService->getList();
$smarty->assign('categories_shared',$categories);

$dispatcher = new Dispatcher($di);
$dispatcher->dispatch();

(new Kernel())->run();




