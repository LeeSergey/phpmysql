<?php
namespace App\Product;
use App\Db\Db;

use App\Request;

class ProductService {

    public function getList(int $limit = 100, int $offset = 0) {
        $query = "SELECT p.*, c.name as category_name FROM products AS p LEFT JOIN categories AS c ON p.category_id = c.id LIMIT $offset, $limit";

        $products = Db::fetchAll($query);

        foreach ($products as &$product) {
            $images = ProductImageService::getListByProductId($product['id']);
            $product['images'] = $images;
        }

        return $products;

    }

    public function getListByCategory ($category_id){
        $query = "SELECT p.*, c.name as category_name FROM products AS p LEFT JOIN categories AS c ON p.category_id = c.id WHERE p.category_id = $category_id";

        $products = Db::fetchAll($query);

        $productImageService = new ProductImageService();
        foreach ($products as &$product) {
            $images = $productImageService->getListByProductId($product['id']);
            $product['images'] = $images;
        }

        return $products;

    }

    public function getById($id) {
        $query = "SELECT p.* , c.id AS category_id FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id";
        $product = Db::fetchRow($query);
        $product['images'] = ProductImageService::getListByProductId($id);
        return $product;
    }

    public function updateById(int $id, array $product): int
    {

        return Db::update('products', $product ,"id = $id");

    }

    public function add(array $product): int
    {
        if (isset($product['id'])){
            unset($product['id']);
        }
        return Db::insert('products',$product);

    }

    public function deleteById(int $id)
    {
        $path = APP_UPLOAD_PRODUCT_DIR . '/' . $id;
        deleteDir($path);

        ProductImageService::deleteByProductId($id);

        return Db::delete('products',"id = $id");
    }

    public function getDataFromPost(Request $request){
        return [
            'id'            => Db::escape($request->getIntFromPost('id',false)),
            'name'          => Db::escape($request->getStrFromPost('name')),
            'article'       => Db::escape($request->getStrFromPost('article')),
            'price'         => Db::escape($request->getIntFromPost('price')),
            'amount'        => Db::escape($request->getIntFromPost('amount')),
            'description'   => Db::escape($request->getStrFromPost('description')),
            'category_id'   => Db::escape($request->getIntFromPost('category_id')),
        ];
    }

    public function getByField(string $mainfield ,string $value)
    {
        $mainfield = Db::escape($mainfield);
        $value = Db::escape($value);
        $query = "SELECT * FROM products WHERE `$mainfield` = '$value'";
        return Db::fetchRow($query);
    }

}