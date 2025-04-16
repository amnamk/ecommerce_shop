<?php

/**
* @OA\Get(
*     path="/special-products/available",
*     tags={"special-products"},
*     summary="Get all available special products",
*     @OA\Response(
*         response=200,
*         description="Returns all available special products"
*     )
* )
*/
Flight::route('GET /special-products/available', function() {
    Flight::json(Flight::specialProductService()->getAvailableProducts());
});


/**
* @OA\Get(
*     path="/special-products/discount/{discount}",
*     tags={"special-products"},
*     summary="Get special products by discount",
*     @OA\Parameter(
*         name="discount",
*         in="path",
*         required=true,
*         description="Discount value to filter special products",
*         @OA\Schema(type="number", example=20.0)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns special products filtered by discount"
*     )
* )
*/
Flight::route('GET /special-products/discount/@discount', function($discount) {
    Flight::json(Flight::specialProductService()->getByDiscount($discount));
});


/**
* @OA\Get(
*     path="/special-products/search/{name}",
*     tags={"special-products"},
*     summary="Search special products by name",
*     @OA\Parameter(
*         name="name",
*         in="path",
*         required=true,
*         description="Name of the special product to search for",
*         @OA\Schema(type="string", example="Product X")
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns special products that match the name"
*     )
* )
*/
Flight::route('GET /special-products/search/@name', function($name) {
    Flight::json(Flight::specialProductService()->searchByName($name));
});


/**
* @OA\Post(
*     path="/special-products",
*     tags={"special-products"},
*     summary="Create a new special product",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"name", "price", "discount", "category"},
*             @OA\Property(property="name", type="string", example="Special Product A"),
*             @OA\Property(property="price", type="number", example=299.99),
*             @OA\Property(property="discount", type="number", example=15.0),
*             @OA\Property(property="category", type="string", example="electronics")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Special product created successfully",
*         @OA\JsonContent(
*             @OA\Property(property="message", type="string", example="Special product created successfully"),
*             @OA\Property(property="id", type="integer", example=1)
*         )
*     )
* )
*/
Flight::route('POST /special-products', function() {
    $data = Flight::request()->data->getData();
    $result = Flight::specialProductService()->create($data);
    Flight::json(["message" => "Special product created successfully", "id" => $result]);
});


/**
* @OA\Put(
*     path="/special-products/{id}/stock/{quantity}",
*     tags={"special-products"},
*     summary="Update special product stock",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the special product to update",
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
Flight::route('PUT /special-products/@id/stock/@quantity', function($id, $quantity) {
    $result = Flight::specialProductService()->updateStock($id, $quantity);
    Flight::json(["message" => "Stock updated successfully", "result" => $result]);
});


/**
* @OA\Delete(
*     path="/special-products/{id}",
*     tags={"special-products"},
*     summary="Delete a special product by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the special product to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Special product deleted successfully"
*     )
* )
*/
Flight::route('DELETE /special-products/@id', function($id) {
    Flight::specialProductService()->delete($id);
    Flight::json(["message" => "Special product deleted successfully"]);
});

?>
