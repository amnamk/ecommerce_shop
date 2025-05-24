
<?php
/**
* @OA\Get(
*     path="/user/{email}",
*     tags={"user"},
*     summary="Get user by email",
*     @OA\Parameter(
*         name="email",
*         in="path",
*         required=true,
*         description="Email address of the user",
*         @OA\Schema(type="string", example="user@example.com")
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns the user data based on the email"
*     )
* )
*/
Flight::route('GET /user/@email', function($email){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::json(Flight::userService()->getUserByEmail($email));
});

/**
* @OA\Get(
*     path="/users/all",
*     tags={"user"},
*     summary="Get all users",
*     @OA\Response(
*         response=200,
*         description="Returns a list of all users"
*     )
* )
*/
Flight::route('GET /users/all', function(){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::json(Flight::userService()->getAll());
});

/**
* @OA\Get(
*     path="/users",
*     tags={"user"},
*     summary="Get users by role",
*     @OA\Parameter(
*         name="role",
*         in="query",
*         required=false,
*         description="Role of the user to filter",
*         @OA\Schema(type="string", example="admin")
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns a list of users filtered by role"
*     )
* )
*/
Flight::route('GET /users', function(){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   $role = Flight::request()->query['role'] ?? null;
   Flight::json(Flight::userService()->getUserByRole($role));
});

/**
* @OA\Post(
*     path="/user",
*     tags={"user"},
*     summary="Create a new user",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"email", "name", "role", "password"},
*             @OA\Property(property="email", type="string", example="user@example.com"),
*             @OA\Property(property="name", type="string", example="John Doe"),
*             @OA\Property(property="role", type="string", example="admin"),
*             @OA\Property(property="password", type="string", example="password123")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="User created successfully"
*     )
* )
*/
Flight::route('POST /user', function(){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
   $data = Flight::request()->data->getData();
   Flight::json(Flight::userService()->insertUser($data));
});

/**
* @OA\Put(
*     path="/user/password",
*     tags={"user"},
*     summary="Update user's password",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"email", "newPassword"},
*             @OA\Property(property="email", type="string", example="user@example.com"),
*             @OA\Property(property="newPassword", type="string", example="newpassword123")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Password updated successfully"
*     )
* )
*/
Flight::route('PUT /user/password', function(){
   $data = Flight::request()->data->getData();
   $email = $data['email'];
   $newPassword = $data['newPassword'];
   Flight::json(Flight::userService()->updatePassword($email, $newPassword));
});

/**
* @OA\Get(
*     path="/user/{id}",
*     tags={"user"},
*     summary="Get user by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the user to fetch",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="User retrieved successfully"
*     ),
*     @OA\Response(
*         response=404,
*         description="User not found"
*     )
* )
*/
Flight::route('GET /user/@id', function($id){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
   Flight::json(Flight::userService()->getByUserId($id));
});

/**
* @OA\Delete(
*     path="/user/{id}",
*     tags={"user"},
*     summary="Delete user by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the user to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="User deleted successfully"
*     )
* )
*/
Flight::route('DELETE /user/@id', function($id){
   $token = Flight::request()->getHeader("Authentication");
   Flight::auth_middleware()->verifyToken($token);
   Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
   Flight::json(Flight::userService()->delete($id));
});


/**
 * @OA\Patch(
 *     path="/user/{id}",
 *     tags={"user"},
 *     summary="Update user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to update",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="new@example.com"),
 *             @OA\Property(property="name", type="string", example="New Name"),
 *             @OA\Property(property="role", type="string", example="user")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     )
 * )
 */
Flight::route('PATCH /user/@id', function($id){
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    unset($data['id']);
    Flight::json(Flight::userService()->updateUser($id, $data));
});



?>
