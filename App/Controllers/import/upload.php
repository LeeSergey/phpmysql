<?php

/*$file = $_FILES['import_file'] ?? null;

if (is_null($file) || empty($file['name'])){
    die('not import file uploaded');
}

$uploadDir = APP_UPLOAD_DIR . '/import';

if (!file_exists($uploadDir)){
    mkdir($uploadDir);
}

$importFilename = 'i_' . time() . '.' . $file['name'];
move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $importFilename);*/

$filename = 'i_1626242786.import.csv';
$filepath = APP_UPLOAD_DIR . '/import/' . $filename;

TasksQueue::addTask([
    'name' => 'Импорт товаров ' .$filename,
    'task' => 'Import::productsFromFileTask()',
    'params' => [
        'filename' => $filename
    ],
]);

exit;

$file = fopen($filepath, 'r');

$withHeader = true;
$settings = [
    0 => 'name',
    1 => 'category_name',
    2 => 'article',
    3 => 'price',
    4 => 'amount',
    5 => 'description',
    6 => 'image_urls',
];

$mainField = 'article';

if ($withHeader) {
    $headers = fgetcsv($file);
}

while ($row = fgetcsv($file)){
    $productData = [];

    foreach ($settings  as $index => $key) {
        $productData[$key] = $row[$index] ?? null;
    }

    $product = [
        'name'          => Db::escape($productData['name']),
        'article'       => Db::escape($productData['article']),
        'price'         => Db::escape($productData['price']),
        'amount'        => Db::escape($productData['amount']),
        'description'   => Db::escape($productData['description']),
    ];

    $categoryName = $productData['category_name'];

    $category = Category::getByName($categoryName);

    if (empty($category)) {
        //continue;
        $categoryId = Category::add([
            'name' => $categoryName,
        ]);
    } else $categoryId = $category['id'];

    $product['category_id'] = $categoryId;

    $targetProduct = Product::getByField($mainField, $product[$mainField]);
    if (empty($targetProduct)){
        $productId = Product::add($product);
    } else {
        $productId = $targetProduct['id'];
        $targetProduct = array_merge($targetProduct, $product);
        Product::updateById($productId, $targetProduct);
    }

    //$productId = Product::add($product);

    $productData['image_urls'] = explode("\n" , $productData['image_urls']);
    $productData['image_urls'] = array_map(function ($item){
        return trim($item);
    }, $productData['image_urls']);
    $productData['image_urls'] = array_filter($productData['image_urls'], function ($item){
        return !empty($item);
    });

    foreach ($productData['image_urls'] as $imageUrl){
        ProductImage::uploadImagesByUrl($productId , $imageUrl);
    }
}

Response::redirect('/products/');

/**
 * 1. Загрузка файла с предварительными настройками
 * 2. Анализ файла на основе предварительных настроек
 * 3. Мы должны указать настройки разбора
 * 4. Разбор файла на основе настроек
 */