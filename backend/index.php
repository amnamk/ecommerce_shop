<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/data/roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;



require_once __DIR__ . '/services/AuthService.php';
Flight::register('authService', 'AuthService'); 

require_once __DIR__ . '/services/UserService.php';  
Flight::register('userService', 'UserService');

require_once __DIR__ . '/services/CartService.php';  
Flight::register('cartService', 'CartService');

require_once __DIR__ . '/services/FavoritesService.php';  
Flight::register('favoritesService', 'FavoritesService');

require_once __DIR__ . '/services/GeneralService.php';  
Flight::register('generalService', 'GeneralService');

require_once __DIR__ . '/services/PaymentService.php';  
Flight::register('paymentService', 'PaymentService');

require_once __DIR__ . '/services/ProductService.php';  
Flight::register('productService', 'ProductService');

require_once __DIR__ . '/services/SpecialProductService.php';  
Flight::register('specialProductService', 'SpecialProductService');


require_once __DIR__ . '/routes/UserRoutes.php';  
require_once __DIR__ . '/routes/CartRoutes.php';  
require_once __DIR__ . '/routes/FavoritesRoutes.php';
require_once __DIR__ . '/routes/GeneralRoutes.php';
require_once __DIR__ . '/routes/PaymentRoutes.php'; 
require_once __DIR__ . '/routes/ProductRoutes.php';
require_once __DIR__ . '/routes/SpecialProductsRoutes.php';
require_once __DIR__ . '/routes/AuthRoutes.php';


require_once __DIR__ . '/middleware/AuthMiddleware.php';
Flight::register('auth_middleware', 'AuthMiddleware');


Flight::route('/*', function() {
    $url = Flight::request()->url;

    
    if (strpos($url, '/auth/login') === 0 || strpos($url, '/auth/register') === 0) {
        return TRUE;
    } else {
        
        $token = Flight::request()->getHeader("Authentication");
        if (!$token) {
            Flight::halt(401, "Missing authentication header");
        }

        try {
            
            if (Flight::auth_middleware()->verifyToken($token)) {
                return TRUE;
            }
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});

Flight::start();

?>
