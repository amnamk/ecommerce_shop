<?php

/**
* @OA\Get(
*     path="/general/search/{title}",
*     tags={"general"},
*     summary="Search for items by title",
*     @OA\Parameter(
*         name="title",
*         in="path",
*         required=true,
*         description="Title of the item to search for",
*         @OA\Schema(type="string", example="Sample Title")
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the items matching the search title"
*     )
* )
*/
Flight::route('GET /general/search/@title', function($title) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::generalService()->searchByTitle($title));
});


/**
* @OA\Get(
*     path="/general/author/{author}",
*     tags={"general"},
*     summary="Get items by author",
*     @OA\Parameter(
*         name="author",
*         in="path",
*         required=true,
*         description="Author name to get items",
*         @OA\Schema(type="string", example="John Doe")
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the items by the specified author"
*     )
* )
*/
Flight::route('GET /general/author/@author', function($author) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::generalService()->getByAuthor($author));
});


/**
* @OA\Get(
*     path="/general",
*     tags={"general"},
*     summary="Get all items",
*     @OA\Response(
*         response=200,
*         description="Returns all items"
*     )
* )
*/
Flight::route('GET /general', function() {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::generalService()->getAll());
});


/**
* @OA\Post(
*     path="/general",
*     tags={"general"},
*     summary="Create a new item",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"title", "author", "description"},
*             @OA\Property(property="title", type="string", example="New Item"),
*             @OA\Property(property="author", type="string", example="John Doe"),
*             @OA\Property(property="description", type="string", example="Description of the item")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Item created successfully",
*         @OA\JsonContent(
*             @OA\Property(property="message", type="string", example="Item created successfully"),
*             @OA\Property(property="id", type="integer", example=1)
*         )
*     )
* )
*/
Flight::route('POST /general', function() {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    $result = Flight::generalService()->create($data);
    Flight::json(["message" => "Item created successfully", "id" => $result]);
});


/**
* @OA\Delete(
*     path="/general/{id}",
*     tags={"general"},
*     summary="Delete an item by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the item to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Item deleted successfully"
*     )
* )
*/
Flight::route('DELETE /general/@id', function($id) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::generalService()->delete($id);
    Flight::json(["message" => "Item deleted successfully"]);
});

?>
