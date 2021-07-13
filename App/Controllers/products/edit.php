<?php

$productId = Request::getIntFromGet('id');
$product = [];

if ($productId) {
    $product = Product::getById($productId);
}

if (Request::isPost()){

    $productData = Product::getDataFromPost();
    $edited = Product::updateById($productId, $productData);

    $uploadImages = $_FILES['images'] ?? [];
    $imageNames = $uploadImages['name'];
    $imageTmpNames = $uploadImages['tmp_name'];
    /**
     * Вариант с заменой изображений с одинаковым именем
     */
//    $currentImageNames = [];
//    foreach ($product['images'] as $image) {
//        $currentImageNames[] = $image['name'];
//    }
//
//    $diffImageNames = array_diff($imageNames, $currentImageNames);
    /**
     * -
     */

    $path = APP_UPLOAD_PRODUCT_DIR . '/' . $productId;

    if (!file_exists($path)){
        mkdir($path);
    }

    for ($i = 0; $i < count($imageNames); $i++){

        $imageName = basename($imageNames[$i]);
        $imageTmpName = $imageTmpNames[$i];

        /**
         * Вариант с заменой изображений с одинаковым именем
         */

//        $imagePath = $path . '/' . $imageName;
//
//        move_uploaded_file($imageTmpName, $imagePath);
//        if (in_array($imageName, $diffImageNames)){
//            ProductImage::add([
//                'product_id'    => $productId,
//                'name'          => $imageName,
//                'path'          => str_replace(APP_PUBLIC_DIR, '', $imagePath),
//            ]);
//        }

        /**
         * Вариант с изменением совпадающих имен изображений
        */

        $filename = $imageName;
        $counter = 0;
        while (true){
            $duplicateImage = ProductImage::findByFilenameInProduct($productId, $filename);
            if (empty($duplicateImage)){
                break;
            }

            $info = pathinfo($imageName);
            $filename = $info['filename'];
            $filename .= '_' . $counter . '.' . $info['extension'];

            $counter++;
        }

        $imagePath = $path . '/' . $filename;

        move_uploaded_file($imageTmpName, $imagePath);

        ProductImage::add([
            'product_id'    => $productId,
            'name'          => $filename,
            'path'          => str_replace(APP_PUBLIC_DIR, '', $imagePath),
        ]);

    }

    /*if ($edited) {
        Response::redirect('/products/list');
    } else {
        die("some edit error");
    }*/

    Response::redirect('/products/list');

}

$categories = Category::getList();

$smarty->assign('product',$product);
$smarty->assign('categories',$categories);
$smarty->display('products/edit.tpl');

/**
 * 1. Проверять был ли отправлен POST запрос на эту страницу
 * 2. Полученные данные записывать в базу данных
 * 3. Делать редирект на главную страницу
 */

?>