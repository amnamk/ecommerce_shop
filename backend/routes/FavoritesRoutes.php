<?php

/**
* @OA\Get(
*     path="/favorites/user/{userId}",
*     tags={"favorites"},
*     summary="Get all favorites for a user",
*     @OA\Parameter(
*         name="userId",
*         in="path",
*         required=true,
*         description="User ID to retrieve their favorite items",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the favorites for the specified user"
*     )
* )
*/
Flight::route('GET /favorites/user/@userId', function($userId) {
    $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::favoritesService()->getByUserId($userId));
});


/**
* @OA\Get(
*     path="/favorites/product/{productId}",
*     tags={"favorites"},
*     summary="Get favorites by product ID",
*     @OA\Parameter(
*         name="productId",
*         in="path",
*         required=true,
*         description="Product ID to retrieve favorites for",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns favorites for the specified product"
*     )
* )
*/
Flight::route('GET /favorites/product/@productId', function($productId) {
    $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::favoritesService()->getByProductId($productId));
});


/**
* @OA\Get(
*     path="/favorites/products/{userId}",
*     tags={"favorites"},
*     summary="Get all favorite products for a user",
*     @OA\Parameter(
*         name="userId",
*         in="path",
*         required=true,
*         description="User ID to retrieve their favorite products",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the favorite products for the specified user"
*     )
* )
*/
Flight::route('GET /favorites/products/@userId', function($userId) {
    $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::favoritesService()->getFavoriteProducts($userId));
});


/**
* @OA\Get(
*     path="/favorites/special-products/{userId}",
*     tags={"favorites"},
*     summary="Get favorite special products for a user",
*     @OA\Parameter(
*         name="userId",
*         in="path",
*         required=true,
*         description="User ID to retrieve their favorite special products",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the favorite special products for the specified user"
*     )
* )
*/
Flight::route('GET /favorites/special-products/@userId', function($userId) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::favoritesService()->getFavoriteSpecialProducts($userId));
});


/**
* @OA\Get(
*     path="/favorites/all/{userId}",
*     tags={"favorites"},
*     summary="Get all favorites for a user",
*     @OA\Parameter(
*         name="userId",
*         in="path",
*         required=true,
*         description="User ID to retrieve all their favorite products",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns all favorites for the specified user"
*     )
* )
*/
Flight::route('GET /favorites/all/@userId', function($userId) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::favoritesService()->getAllFavoriteProducts($userId));
});


/**
* @OA\Post(
*     path="/favorites",
*     tags={"favorites"},
*     summary="Add a product to favorites",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"userId", "productId"},
*             @OA\Property(property="userId", type="integer", example=1),
*             @OA\Property(property="productId", type="integer", example=10)
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Product added to favorites successfully"
*     )
* )
*/
Flight::route('POST /favorites', function() {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    Flight::favoritesService()->create($data);
    Flight::json(["message" => "Favorite added successfully"]);
});


/**
* @OA\Delete(
*     path="/favorites/{id}",
*     tags={"favorites"},
*     summary="Delete a favorite by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the favorite to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Favorite deleted successfully"
*     )
* )
*/
Flight::route('DELETE /favorites/@id', function($id) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::favoritesService()->delete($id);
    Flight::json(["message" => "Favorite deleted successfully"]);
});

?>
