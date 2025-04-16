<?php

require_once __DIR__ . '/vendor/autoload.php';
 
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


Flight::start();
?>
