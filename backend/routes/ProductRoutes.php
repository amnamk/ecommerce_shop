<?php

/**
* @OA\Get(
*     path="/products",
*     tags={"products"},
*     summary="Get all products",
*     @OA\Response(
*         response=200,
*         description="Returns all products"
*     )
* )
*/
Flight::route('GET /products', function() {
    Flight::json(Flight::productService()->getAllProducts());
});


/**
* @OA\Get(
*     path="/products/{id}",
*     tags={"products"},
*     summary="Get product by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the product to retrieve",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the product with the specified ID"
*     )
* )
*/
Flight::route('GET /products/@id', function($id) {
    Flight::json(Flight::productService()->getById($id));
});


/**
* @OA\Get(
*     path="/products/category/{category}",
*     tags={"products"},
*     summary="Get products by category",
*     @OA\Parameter(
*         name="category",
*         in="path",
*         required=true,
*         description="Category of products to retrieve",
*         @OA\Schema(type="string", example="electronics")
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns products for the specified category"
*     )
* )
*/
Flight::route('GET /products/category/@category', function($category) {
    Flight::json(Flight::productService()->getByCategory($category));
});


/**
* @OA\Post(
*     path="/products",
*     tags={"products"},
*     summary="Create a new product",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"name", "price", "category"},
*             @OA\Property(property="name", type="string", example="Product A"),
*             @OA\Property(property="price", type="number", example=199.99),
*             @OA\Property(property="category", type="string", example="electronics")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Product created successfully",
*         @OA\JsonContent(
*             @OA\Property(property="message", type="string", example="Product created successfully"),
*             @OA\Property(property="id", type="integer", example=1)
*         )
*     )
* )
*/
Flight::route('POST /products', function() {
    $data = Flight::request()->data->getData();
    $result = Flight::productService()->create($data);
    Flight::json(["message" => "Product created successfully", "id" => $result]);
});


/**
* @OA\Put(
*     path="/products/{id}/stock/{quantity}",
*     tags={"products"},
*     summary="Update product stock quantity",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the product to update",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Parameter(
*         name="quantity",
*         in="path",
*         required=true,
*         description="Quantity to add or subtract from the stock",
*         @OA\Schema(type="integer", example=10)
*     ),
*     @OA\Response(
*         response=200,
*         description="Stock updated successfully"
*     )
* )
*/
Flight::route('PUT /products/@id/stock/@quantity', function($id, $quantity) {
    $result = Flight::productService()->updateStockQuantity($id, $quantity);
    Flight::json(["message" => "Stock updated successfully", "result" => $result]);
});


/**
* @OA\Delete(
*     path="/products/{id}",
*     tags={"products"},
*     summary="Delete a product by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the product to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Product deleted successfully"
*     )
* )
*/
Flight::route('DELETE /products/@id', function($id) {
    Flight::productService()->delete($id);
    Flight::json(["message" => "Product deleted successfully"]);
});

?>
