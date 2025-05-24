<?php


/**
* @OA\Get(
*     path="/cart/user/{user_id}",
*     tags={"cart"},
*     summary="Get all cart items for a user",
*     @OA\Parameter(
*         name="user_id",
*         in="path",
*         required=true,
*         description="User ID to retrieve the cart items",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the cart for the specified user"
*     )
* )
*/
Flight::route('GET /cart/user/@user_id', function($user_id){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::json(Flight::cartService()->getCartByUserId($user_id));
});

/**
* @OA\Get(
*     path="/cart/regular/user/{user_id}",
*     tags={"cart"},
*     summary="Get regular products in the user's cart",
*     @OA\Parameter(
*         name="user_id",
*         in="path",
*         required=true,
*         description="User ID to retrieve the regular products",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns regular products in the user's cart"
*     )
* )
*/
Flight::route('GET /cart/regular/user/@user_id', function($user_id){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::json(Flight::cartService()->getCartRegularProducts($user_id));
});

/**
* @OA\Get(
*     path="/cart/special/user/{user_id}",
*     tags={"cart"},
*     summary="Get special products in the user's cart",
*     @OA\Parameter(
*         name="user_id",
*         in="path",
*         required=true,
*         description="User ID to retrieve the special products",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns special products in the user's cart"
*     )
* )
*/
Flight::route('GET /cart/special/user/@user_id', function($user_id){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::json(Flight::cartService()->getCartSpecialProducts($user_id));
});

/**
* @OA\Get(
*     path="/cart/items/user/{user_id}",
*     tags={"cart"},
*     summary="Get items in the user's cart",
*     @OA\Parameter(
*         name="user_id",
*         in="path",
*         required=true,
*         description="User ID to retrieve the cart items",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the items in the user's cart"
*     )
* )
*/
Flight::route('GET /cart/items/user/@user_id', function($user_id){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::json(Flight::cartService()->getCartItems($user_id));
});

/**
* @OA\Delete(
*     path="/cart/item/{id}",
*     tags={"cart"},
*     summary="Delete an item from the cart",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the cart item to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Item successfully deleted from the cart"
*     )
* )
*/
Flight::route('DELETE /cart/item/@id', function($id){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::cartService()->delete($id);
   Flight::json(['status' => 'success', 'message' => 'Item deleted successfully']);
});

/**
* @OA\Post(
*     path="/cart",
*     tags={"cart"},
*     summary="Add an item to the cart",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"product_id", "quantity"},
*             @OA\Property(property="product_id", type="integer", example=1),
*             @OA\Property(property="quantity", type="integer", example=2)
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Item added to the cart successfully"
*     )
* )
*/
Flight::route('POST /cart', function(){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    Flight::cartService()->create($data);
    Flight::json(['status' => 'success', 'message' => 'Item added to cart']);
});

/**
* @OA\Put(
*     path="/cart/item/{id}",
*     tags={"cart"},
*     summary="Update quantity of an item in the cart",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the cart item to update",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"quantity"},
*             @OA\Property(property="quantity", type="integer", example=3)
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Cart item updated successfully"
*     ),
*     @OA\Response(
*         response=400,
*         description="Invalid quantity"
*     )
* )
*/
Flight::route('PUT /cart/item/@id', function($id) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);

    $data = Flight::request()->data->getData();
    $quantity = isset($data['quantity']) ? intval($data['quantity']) : null;

    if ($quantity === null || $quantity < 1) {
        Flight::halt(400, 'Invalid quantity.');
    }

    $result = Flight::cartService()->updateItemQuantity($id, $quantity);
    Flight::json(["message" => "Cart item updated successfully", "result" => $result]);
});


?>
