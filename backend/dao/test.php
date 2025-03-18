<?php
require_once 'ProductDao.php';
require_once 'SpecialProductDao.php';


$productDao = new ProductDao();
$specialProductDao = new SpecialProductDao();


$product = [
    'name' => 'Test Product',
    'description' => 'This is a test product.',
    'price' => 99.99,
    'stock_quantity' => 50,
    'reviews' => 4.5,
    'category' => 'Test Category',
    'picture' => 'test_product.jpg'
];

$productDao->insert($product);


$product = $productDao->getById(1); 
if ($product) {
    $productId = $product['product_id'];
    echo "Product ID: $productId\n";
}


$specialProduct = [
    'product_id' => $productId,
    'discount' => 20,
    'name' => 'Special Test Product',
    'description' => 'This is a special product.',
    'price' => 79.99,
    'stock_quantity' => 30,
    'reviews' => 4.8,
    'picture' => 'special_test_product.jpg'
];

$specialProductDao->insert($specialProduct);


$specialProduct = $specialProductDao->getById(1); 
if ($specialProduct) {
    echo "Special Product Retrieved: " . $specialProduct['name'] . "\n";
}


$updateData = ['price' => 69.99]; 
$specialProductDao->update(1, $updateData);


$specialProductDao->delete(1);


$deletedProduct = $specialProductDao->getById(1);
if (!$deletedProduct) {
    echo "Special product with ID 1 has been deleted.\n";
}
?>
