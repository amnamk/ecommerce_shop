<?php

/**
* @OA\Get(
*     path="/payments",
*     tags={"payments"},
*     summary="Get all payments",
*     @OA\Response(
*         response=200,
*         description="Returns all payments"
*     )
* )
*/
Flight::route('GET /payments', function() {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::paymentService()->getAllPayments());
});


/**
* @OA\Get(
*     path="/payments/state/{state}",
*     tags={"payments"},
*     summary="Get payments by state",
*     @OA\Parameter(
*         name="state",
*         in="path",
*         required=true,
*         description="State to filter payments",
*         @OA\Schema(type="string", example="completed")
*     ),
*     @OA\Response(
*         response=200,
*         description="Returns payments for the specified state"
*     )
* )
*/
Flight::route('GET /payments/state/@state', function($state) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::paymentService()->getPaymentsByState($state));
});


/**
* @OA\Post(
*     path="/payments",
*     tags={"payments"},
*     summary="Create a new payment",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"amount", "method", "state"},
*             @OA\Property(property="amount", type="number", example=100.50),
*             @OA\Property(property="method", type="string", example="credit_card"),
*             @OA\Property(property="state", type="string", example="pending")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Payment created successfully",
*         @OA\JsonContent(
*             @OA\Property(property="message", type="string", example="Payment created successfully"),
*             @OA\Property(property="id", type="integer", example=1)
*         )
*     )
* )
*/
Flight::route('POST /payments', function() {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    $result = Flight::paymentService()->create($data);
    Flight::json(["message" => "Payment created successfully", "id" => $result]);
});


/**
* @OA\Delete(
*     path="/payments/{id}",
*     tags={"payments"},
*     summary="Delete a payment by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the payment to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Payment deleted successfully"
*     )
* )
*/
Flight::route('DELETE /payments/@id', function($id) {
    $token = Flight::request()->getHeader("Authentication");
    Flight::auth_middleware()->verifyToken($token);
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::paymentService()->delete($id);
    Flight::json(["message" => "Payment deleted successfully"]);
});

?>
